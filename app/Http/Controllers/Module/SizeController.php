<?php

namespace App\Http\Controllers\Module;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Size;

class SizeController extends Controller
{
    public function __construct()
    {
        $this->namemodel = 'Size';
        $this->model = new Size();
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'height' => 'required|integer',
                'weight' => 'required|integer',
                'clothing_size' => 'required|string',
                'pants_size' => 'required|integer',
                'shoe_size' => 'required|integer',
            ]);
            
            if ($validator->fails()) {
                // Gabungkan semua pesan error menjadi satu string
                $errors = implode('<br>', $validator->errors()->all());
                return response()->json(['error' => $errors]);
            }

            // Ambil nilai personal_data_id dari metode
            $personalDataId = $this->getPersonaldataByid();

            // Cek apakah sudah ada data dengan personal_data_id yang sama
            $existingData = $this->model->where('personal_data_id', $personalDataId)->first();

            if ($existingData) {
                return response()->json(['error' => 'Data is already exists. You can only add one row of data!']);
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
                'height' => 'required|integer',
                'weight' => 'required|integer',
                'clothing_size' => 'required|string',
                'pants_size' => 'required|integer',
                'shoe_size' => 'required|integer',
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
