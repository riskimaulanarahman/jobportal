<?php

namespace App\Http\Controllers\Module;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Family;

class FamilyController extends Controller
{
    public function __construct()
    {
        $this->namemodel = 'Family';
        $this->model = new Family();
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'members' => 'required|string|max:255', // Misalnya jumlah anggota harus angka positif
                'name' => 'required|string|max:255', // Nama biasanya string
                'gender' => 'required|in:M,F', // Gender bisa jadi opsi tertentu
                'birth_place' => 'required|string|max:255', // Tempat lahir biasanya string
                'date_of_birth' => 'required|date', // Tanggal lahir harus format tanggal
                'country_of_birth' => 'required|string|max:255', // Negara tempat lahir string
                'nationality' => 'required|string|max:255', // Kewarganegaraan string
            ]);
            
            if ($validator->fails()) {
                // Gabungkan semua pesan error menjadi satu string
                $errors = implode('<br>', $validator->errors()->all());
                return response()->json(['error' => $errors]);
            }

            // Ambil nilai personal_data_id dari metode
            $personalDataId = $this->getPersonaldataByid();

            // Cek apakah sudah ada data dengan personal_data_id yang sama
            $existingData = $this->model->where('personal_data_id', $personalDataId)->where('members',$request->members)->first();

            if ($existingData) {
                return response()->json(['error' => 'Data '.$request->members.' already exists. You can only add one row of data!']);
            }

            // Ambil platform dari input
            $platform = strtolower($request->platform);

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
                'members' => 'required|string|max:255', // Misalnya jumlah anggota harus angka positif
                'name' => 'required|string|max:255', // Nama biasanya string
                'gender' => 'required|in:M,F', // Gender bisa jadi opsi tertentu
                'birth_place' => 'required|string|max:255', // Tempat lahir biasanya string
                'date_of_birth' => 'required|date', // Tanggal lahir harus format tanggal
                'country_of_birth' => 'required|string|max:255', // Negara tempat lahir string
                'nationality' => 'required|string|max:255', // Kewarganegaraan string
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
