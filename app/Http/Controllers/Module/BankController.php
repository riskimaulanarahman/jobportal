<?php

namespace App\Http\Controllers\Module;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Bank;

class BankController extends Controller
{
    public function __construct()
    {
        $this->namemodel = 'Bank';
        $this->model = new Bank();
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'payee' => 'required|string|max:255',
                'bank_country' => 'required|string', // Sesuaikan negara sesuai opsi pada form
                'bank_name' => 'required|string', // Sesuaikan bank sesuai opsi pada form
                'branch_address' => 'required|string|max:255',
                'account_number' => 'required|numeric|digits_between:6,50', // Sesuaikan digit minimal dan maksimal untuk nomor rekening
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
            $existingData = $this->model->where('personal_data_id', $personalDataId)->where('bank_name',$param1)->first();

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
                'payee' => 'required|string|max:255',
                'bank_country' => 'required|string', // Sesuaikan negara sesuai opsi pada form
                'bank_name' => 'required|string', // Sesuaikan bank sesuai opsi pada form
                'branch_address' => 'required|string|max:255',
                'account_number' => 'required|numeric|digits_between:6,50', // Sesuaikan digit minimal dan maksimal untuk nomor rekening
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
