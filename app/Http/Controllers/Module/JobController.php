<?php

namespace App\Http\Controllers\Module;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Module\Job;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class JobController extends Controller
{
    public function __construct()
    {
        $this->namemodel = 'Job';
        $this->model = new Job();
    }
  
    public function index(Request $request)
    {
        $query = $this->model->query();

        // Filtering by keyword
        if ($keyword = $request->get('keyword')) {
            $query->where('job_title', 'LIKE', "%{$keyword}%")
                ->orWhere('code_job', 'LIKE', "%{$keyword}%")
                ->orWhere('category', 'LIKE', "%{$keyword}%")
                ->orWhere('contract_status', 'LIKE', "%{$keyword}%")
                ->orWhere('location', 'LIKE', "%{$keyword}%");
        }

        $data = $query->orderBy('created_at','desc')->paginate(10)->withQueryString(); // Ensure pagination retains filter parameters

        // dd($data);
        
        return view('area.job-posting', compact([
            'data',
        ]));
    }

    public function store(Request $request)
    {
        try {

            $requestData = $request->all();
            // Format skills_required jika berupa array
            if (is_string($requestData['skills_required'])) {
                $requestData['skills_required'] = array_map('trim', explode(',', $requestData['skills_required']));
            }

            $validator = Validator::make($request->all(), [
                'job_title' => 'required|string',
                'category' => 'required|string',
                'contract_status' => 'required|string',
                'location' => 'required|string',
                'experience_years' => 'required|integer',
                'job_description' => 'required|string',
                'skills_required' => 'required|string',
            ]);
            
            if ($validator->fails()) {
                // Gabungkan semua pesan error menjadi satu string
                $errors = implode('<br>', $validator->errors()->all());
                return response()->json(['error' => $errors]);
            }
            
            // Generate kode job otomatis
            $lastJob = $this->model->latest('id')->first();
            $nextId = $lastJob ? $lastJob->id + 1 : 1;
            $requestData['code_job'] = 'JOB-' . str_pad($nextId, 5, '0', STR_PAD_LEFT); // Contoh: JOB-00001
            
            // Buat data baru
            $this->model->create($requestData);

            return response()->json(['success' => $this->namemodel.' added successfully.']);
            
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $requestData = $request->all();
            // Format skills_required jika berupa array
            if (is_string($requestData['skills_required'])) {
                $requestData['skills_required'] = array_map('trim', explode(',', $requestData['skills_required']));
            }

            $validator = Validator::make($request->all(), [
                'job_title' => 'required|string',
                'code_job' => 'required|string',
                'category' => 'required|string',
                'contract_status' => 'required|string',
                'location' => 'required|string',
                'experience_years' => 'required|integer',
                'job_description' => 'required|string',
                'skills_required' => 'required|string',
            ]);
            
            if ($validator->fails()) {
                // Gabungkan semua pesan error menjadi satu string
                $errors = implode('<br>', $validator->errors()->all());
                return response()->json(['error' => $errors]);
            }
        
            // Proses update data
            $data = $this->model->findOrFail($id);

            $data->update($requestData);
        
            return response()->json(['success' => $this->namemodel.' updated successfully.']);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $data = $this->model->findOrFail($id);
            $data->delete();
            return response()->json(['success' => $this->namemodel.' deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function generateDummyData()
    {
        $categories = ['Engineer', 'Marketing', 'Design', 'Finance'];
        $locations = ['Kalimantan Timur', 'Kalimantan Barat', 'Kalimantan Utara'];

        for ($i = 0; $i < 20; $i++) {
            $skills = ['PHP', 'JavaScript', 'Python', 'SQL', 'Linux', 'Cloud Computing'];
            shuffle($skills);
            Job::create([
                'job_title' => 'Job Title ' . $i,
                'code_job' => strtoupper(Str::random(6)),
                'category' => $categories[array_rand($categories)],
                'contract_status' => ['full-time', 'contract'][rand(0, 1)],
                'location' => $locations[array_rand($locations)],
                'experience_years' => rand(0, 20),
                'job_description' => 'This is a description for job ' . $i,
                'skills_required' => array_slice($skills, 0, rand(1, 5))
            ]);
        }

        return redirect()->route('jobs.index')->with('success', 'Dummy data generated.');
    }
}
