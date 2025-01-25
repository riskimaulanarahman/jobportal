<?php

namespace App\Http\Controllers\Module;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Tax;

class TaxController extends Controller
{
    public function __construct()
    {
        $this->namemodel = 'Tax';
        $this->model = new Tax();
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'npwp' => 'required|string|max:15', // NPWP maksimal 15 karakter
                'registered_date' => 'nullable|date', // Tanggal harus dalam format yang valid
                'npwp_address' => 'required|string|max:255', // Alamat maksimal 255 karakter
                'married_for_tax_purpose' => 'required|in:Yes,No', // Harus bernilai Yes atau No
                'spouse_benefit' => 'required|in:Yes,No', // Harus bernilai Yes atau No
                'number_of_dependents' => 'required|integer|min:0|max:10', // Minimal 0, maksimal 10 dependents
                'jamsostek_id' => 'nullable|string|max:20', // Jamsostek ID maksimal 20 karakter
                'bpjs_id' => 'required|string|max:20', // BPJS ID maksimal 20 karakter
                'benefit_class' => 'required|integer|min:0|max:3', // Kelas manfaat harus antara 0-3
                'dependents_count' => 'required|string|in:Use Family Info', // Harus bernilai "Use Family Info"
            ]);
            
            if ($validator->fails()) {
                // Gabungkan semua pesan error menjadi satu string
                $errors = implode('<br>', $validator->errors()->all());
                return response()->json(['error' => $errors]);
            }

            // Ambil nilai personal_data_id dari metode
            $personalDataId = $this->getPersonaldataByid();

            $param1 = $request->bank_name;

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
                'npwp' => 'required|string|max:15', // NPWP maksimal 15 karakter
                'registered_date' => 'nullable|date', // Tanggal harus dalam format yang valid
                'npwp_address' => 'required|string|max:255', // Alamat maksimal 255 karakter
                'married_for_tax_purpose' => 'required|in:Yes,No', // Harus bernilai Yes atau No
                'spouse_benefit' => 'required|in:Yes,No', // Harus bernilai Yes atau No
                'number_of_dependents' => 'required|integer|min:0|max:10', // Minimal 0, maksimal 10 dependents
                'jamsostek_id' => 'nullable|string|max:20', // Jamsostek ID maksimal 20 karakter
                'bpjs_id' => 'required|string|max:20', // BPJS ID maksimal 20 karakter
                'benefit_class' => 'required|integer|min:0|max:3', // Kelas manfaat harus antara 0-3
                'dependents_count' => 'required|string|in:Use Family Info', // Harus bernilai "Use Family Info"
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
