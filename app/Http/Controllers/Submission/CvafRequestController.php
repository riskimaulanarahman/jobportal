<?php

namespace App\Http\Controllers\Submission;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use App\Models\Submission\Project;
use App\Models\ApproverListReq;
use App\Models\ApproverListHistory;
use App\Models\Approvaluser;
use App\Models\Module;
use App\Models\Attachment;
use App\Models\Stackholders;
use App\Http\Traits\ProcessProjectTrait;
use App\Models\CoreValue;
use App\Models\Question;
use App\Models\Answer;
use App\Models\Score;
use DB;

class CvafRequestController extends Controller
{
    use ProcessProjectTrait;
    
    public $model;
    public $modulename;
    public $module;

    public function __construct()
    {
        $this->model = new Project();
        $this->modulename = 'Project';
        $this->module = new Module();
    }

    public function index(Request $request)
    {
        try {
            
            $id = $request->id;
            $user_id = $this->getAuth()->id;
            $module_id = $this->getModuleId($this->modulename);

            $subquery = "(select TOP 1 CASE WHEN a.user_id='".$user_id."'  then 1 else 0 end 
            from tbl_approverListReq l
            left join tbl_approver a on l.approver_id=a.id
            left join tbl_approvaltype r on a.approvaltype_id = r.id 
            where l.ApprovalAction='1' and l.req_id = request_project.id and l.module_id = '".$module_id."' and request_project.requestStatus='1'
            order by a.sequence)";

            $data = $this->model
                ->selectRaw("request_project.*,codes.code,
                    CASE WHEN request_project.user_id='".$user_id."' then 1 else 0 end as isMine,
                    ".$subquery." as isPendingOnMe
                ")
                ->leftJoin('codes','request_project.code_id','codes.id')
                ->with(['user','approverlist'])
                ->where(function ($query) use ($subquery, $user_id) {
                    $query->whereRaw($subquery . " = 1")
                        ->orWhere(function ($query) use ($user_id) {
                            if ($this->getAuth()->isAdmin) {
                                $query->where("request_project.user_id", "!=", $user_id)
                                    ->whereIn("request_project.requestStatus", [1,3,4]);
                            } else {
                                $query->where("request_project.user_id", "!=", $user_id)
                                    ->whereIn("request_project.requestStatus", [3,4]);
                            }
                        })
                        ->orWhere("request_project.user_id", $user_id);
                })
                ->orderBy(DB::raw($subquery), 'DESC')
                ->orderByRaw("CASE WHEN request_project.user_id = '".$user_id."' THEN 0 ELSE 1 END, request_project.created_at desc")
                ->get();

            return response()->json([
                'status' => "show",
                'message' => $this->getMessage()['show'],
                'data' => $data
            ])->setEncodingOptions(JSON_NUMERIC_CHECK);

        } catch (\Exception $e) {

            return response()->json(["status" => "error", "message" => $e->getMessage()]);
        }
    }

    public function store(Request $request)
    {
        try {
            // Ambil semua data dari request
            $requestData = $request->all();

            // Tambahkan user_id ke dalam data request
            $requestData['user_id'] = $this->getAuth()->id;
            $requestData['requestStatus'] = 0;
            $requestData['projectStatus'] = 'Waiting';

            // Buat data baru pada tabel utama
            $newData = $this->model->create($requestData);

            // Simpan id dari data baru
            $req_id = $newData->id;

            // $this->createApproverList($this->modulename, $req_id);
            
            return response()->json([
                "status" => "success",
                "message" => $this->getMessage()['store'],
                "data" => $newData
            ]);

        } catch (\Exception $e) {

            return response()->json(["status" => "error", "message" => $e->getMessage()]);
        }
    }

    public function show($id)
    {
        try {

            $data = $this->model->select('request_project.*','codes.code')
            ->leftJoin('codes','request_project.code_id','codes.id')
            ->where('request_project.id',$id)
            ->first();

            if($data->code_id == null) {
                $data->code_id = $this->generateCode($this->modulename);
                $data->save();
            }

            return response()->json(['status' => "show", "message" => $this->getMessage()['show'] , 'data' => $data])->setEncodingOptions(JSON_NUMERIC_CHECK);

        } catch (\Exception $e) {

            return response()->json(["status" => "error", "message" => $e->getMessage()]);
        }
    }

    public function update(Request $request, $id)
    {
        try {

            // Mengambil semua data dari request
            $module_id = $this->getModuleId($this->modulename);
            $requestData = $request->all();

            
            // Mencari data berdasarkan id dan mengupdate data dengan nilai dari $requestData
            $this->addOneDayToDate($requestData);

            $data = $this->model->findOrFail($id);
            $data->update($requestData);

            //start save history perubahan
            $fields = [
                'projectStatus' => $request->projectStatus,
                'progress' => strval($request->progress),
            ];
            
            foreach ($fields as $key => $value) {
                if ($value) {
                    $this->approverAction($this->modulename, $id, $key, 1, $value, null);
                }
            }
            //end save history perubahan

            // Mengembalikan data dalam bentuk JSON dengan memberikan status, pesan dan data
            return response()->json([
                'status' => "success",
                'message' => $this->getMessage()['update']
            ]);

        } catch (\Exception $e) {

            return response()->json(["status" => "error", "message" => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {

            // Cari module berdasarkan nama modul
            $module = $this->module->select('id', 'module')->where('module', $this->modulename)->first();
            $user_id = $this->getAuth()->id;
            
            // Jika module ditemukan, lakukan delete secara atomik
            if ($module) {
                DB::transaction(function () use ($id, $module, $user_id) {
                    // Hapus data pada tabel ApproverListReq
                    ApproverListReq::where('req_id', $id)
                        ->where('module_id', $module->id)
                        ->delete();
                    ApproverListHistory::where('req_id', $id)
                        ->where('module_id', $module->id)
                        ->delete();
                    $attachments = Attachment::where('req_id', $id)
                        ->where('module_id', $module->id)
                        ->get();
                        Attachment::where('req_id', $id)
                        ->where('module_id', $module->id)
                        ->delete();
                        foreach ($attachments as $attachment) {
                            unlink($this->copyuploadpath().$attachment->path);
                        }
                    Stackholders::where('req_id', $id)
                        ->where('module_id', $module->id)
                        ->delete();

                    // Hapus data pada tabel utama
                    
                    $data = $this->model->where('id',$id)->where('requestStatus',0)->where('user_id',$user_id)->first();
                    if ($data) {
                        $data->delete();
                    } else {
                        throw new \Exception($this->getMessage()['errordestroysubmission']);
                    }
                    
                });

                return  response()->json(["status" => "success", "message" => $this->getMessage()['destroy']]);

            } else {
                return  response()->json(["status" => "error", "message" => $this->getMessage()['modulenotfound']]);
            }


        } catch (\Exception $e) {

            return response()->json(["status" => "error", "message" => $e->getMessage()]);
        }
    }

    public function showEvaluationForm()
    {
        $coreValues = CoreValue::with('questions')->get();
        return view('evaluation_form', compact('coreValues'));
    }

    public function calculateScore(Request $request)
    {
        $weights = [
            'Low' => 1,
            'Mid' => 2,
            'High' => 3,
        ];

        $employeeId = $request->input('employee_id');
        $answers = $request->input('answers');
        $scores = [];

        foreach ($answers as $coreValueId => $coreAnswers) {
            $totalScore = 0;
            $questionCount = count($coreAnswers);

            foreach ($coreAnswers as $questionId => $answer) {
                $totalScore += $weights[$answer];

                // Simpan jawaban
                Answer::create([
                    'question_id' => $questionId,
                    'employee_id' => $employeeId,
                    'answer' => $answer,
                ]);
            }

            $minScore = 1 * $questionCount;
            $maxScore = 3 * $questionCount;
            $scaledScore = 1 + (($totalScore - $minScore) / ($maxScore - $minScore)) * 4;

            // Simpan hasil penilaian
            $scores[] = Score::create([
                'employee_id' => $employeeId,
                'core_value_id' => $coreValueId,
                'total_score' => $totalScore,
                'scaled_score' => round($scaledScore, 2),
            ]);
        }

        return response()->json($scores);
    }
}
