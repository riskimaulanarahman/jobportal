<?php

namespace App\Http\Controllers\Module;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Language;

class LanguageController extends Controller
{
    public function __construct()
    {
        $this->namemodel = 'Language';
        $this->model = new Language();
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'language' => 'required|string',
                'read' => 'required|string',
                'write' => 'required|string',
                'speak' => 'required|string',
            ]);
            
            if ($validator->fails()) {
                // Gabungkan semua pesan error menjadi satu string
                $errors = implode('<br>', $validator->errors()->all());
                return response()->json(['error' => $errors]);
            }

            // Ambil nilai personal_data_id dari metode
            $personalDataId = $this->getPersonaldataByid();

            $param1 = $request->language;

            // Cek apakah sudah ada data dengan personal_data_id yang sama
            $existingData = $this->model->where('personal_data_id', $personalDataId)->where('language',$param1)->first();

            if ($existingData) {
                return response()->json(['error' => $param1 . ' already exists.']);
            }

            // Gabungkan personal_data_id ke dalam data yang dikirim
            $data = $request->all();
            $data['personal_data_id'] = $personalDataId;

            // Buat data baru
            $this->model->create($data);

            return response()->json(['success' => $this->namemodel.' added successfully.']);
            
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function update(Request $request, $id)
    {
        try {

            $validator = Validator::make($request->all(), [
                'language' => 'required|string',
                'read' => 'required|string',
                'write' => 'required|string',
                'speak' => 'required|string',
            ]);
            
            if ($validator->fails()) {
                // Gabungkan semua pesan error menjadi satu string
                $errors = implode('<br>', $validator->errors()->all());
                return response()->json(['error' => $errors]);
            }
        
            $data = $this->model->findOrFail($id);
            $data->update($request->all());
        
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
}
