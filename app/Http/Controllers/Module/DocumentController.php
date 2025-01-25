<?php

namespace App\Http\Controllers\Module;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Document;

class DocumentController extends Controller
{
    public function __construct()
    {
        $this->namemodel = 'Document';
        $this->model = new Document();
    }

    // public function store(Request $request)
    // {
    //     try {
    //         $validator = Validator::make($request->all(), [
    //             'language' => 'required|string',
    //             'read' => 'required|string',
    //             'write' => 'required|string',
    //             'speak' => 'required|string',
    //         ]);
            
    //         if ($validator->fails()) {
    //             // Gabungkan semua pesan error menjadi satu string
    //             $errors = implode('<br>', $validator->errors()->all());
    //             return response()->json(['error' => $errors]);
    //         }

    //         // Ambil nilai personal_data_id dari metode
    //         $personalDataId = $this->getPersonaldataByid();

    //         $param1 = $request->type_document;

    //         // Cek apakah sudah ada data dengan personal_data_id yang sama
    //         $existingData = $this->model->where('personal_data_id', $personalDataId)->where('type_document',$param1)->first();

    //         if ($existingData) {
    //             return response()->json(['error' => $param1 . ' already exists.']);
    //         }

    //         // Gabungkan personal_data_id ke dalam data yang dikirim
    //         $data = $request->all();
    //         $data['personal_data_id'] = $personalDataId;

    //         // Buat data baru
    //         $this->model->create($data);

    //         return response()->json(['success' => $this->namemodel.' added successfully.']);
            
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => $e->getMessage()]);
    //     }
    // }

    public function store(Request $request)
    {
        try {
            // Validasi input
            $validator = Validator::make($request->all(), [
                'type_document_id' => 'required|exists:ref_type_document,id',
                'document' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048', // Validasi file upload
            ]);

            if ($validator->fails()) {
                // Gabungkan semua pesan error menjadi satu string
                $errors = implode('<br>', $validator->errors()->all());
                return response()->json(['error' => $errors], 422);
            }

            // Ambil nilai personal_data_id dari metode
            $personalDataId = $this->getPersonaldataByid();

            // Cek apakah data dengan `type_document_id` dan `personal_data_id` sudah ada
            $existingData = $this->model->where('personal_data_id', $personalDataId)
                ->where('type_document_id', $request->type_document_id)
                ->first();

            if ($existingData) {
                return response()->json(['error' => 'Document with this type already exists.'], 409);
            }

            // Proses upload file
            if ($request->hasFile('document')) {
                $file = $request->file('document');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('document/'.$personalDataId, $fileName, 'public'); // Gunakan storeAs untuk menentukan nama file
            }

            // Gabungkan data untuk disimpan ke database
            $data = [
                'personal_data_id' => $personalDataId,
                'type_document_id' => $request->type_document_id,
                'path' => $filePath ?? null, // Simpan path file
            ];

            // Simpan data ke database
            $this->model->create($data);

            return response()->json(['success' => $this->namemodel . ' added successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // public function update(Request $request, $id)
    // {
    //     try {

    //         $validator = Validator::make($request->all(), [
    //             'language' => 'required|string',
    //             'read' => 'required|string',
    //             'write' => 'required|string',
    //             'speak' => 'required|string',
    //         ]);
            
    //         if ($validator->fails()) {
    //             // Gabungkan semua pesan error menjadi satu string
    //             $errors = implode('<br>', $validator->errors()->all());
    //             return response()->json(['error' => $errors]);
    //         }
        
    //         $data = $this->model->findOrFail($id);
    //         $data->update($request->all());
        
    //         return response()->json(['success' => $this->namemodel.' updated successfully.']);

    //     } catch (\Exception $e) {
    //         return response()->json(['error' => $e->getMessage()]);
    //     }
    // }

    public function update(Request $request, $id)
    {
        try {
            // Validasi input
            $validator = Validator::make($request->all(), [
                'type_document_id' => 'required|exists:ref_type_document,id',
                'document' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048', // File tidak wajib diunggah ulang
            ]);

            if ($validator->fails()) {
                $errors = implode('<br>', $validator->errors()->all());
                return response()->json(['error' => $errors], 422);
            }

            // Cari data berdasarkan ID
            $document = $this->model->findOrFail($id);

            // Update type_document_id hanya jika berbeda
            if ($document->type_document_id != $request->type_document_id) {
                $existingData = $this->model->where('personal_data_id', $document->personal_data_id)
                    ->where('type_document_id', $request->type_document_id)
                    ->first();

                if ($existingData) {
                    return response()->json(['error' => 'Document with this type already exists.'], 409);
                }

                $document->type_document_id = $request->type_document_id;
            }

            // Proses upload file baru jika ada
            if ($request->hasFile('document')) {
                // Hapus file lama jika ada
                $oldFilePath = public_path('upload/'.$document->path); // Lokasi file lama
                if ($document->path && file_exists($oldFilePath)) {
                    unlink($oldFilePath); // Hapus file lama
                }

                // Simpan file baru
                $file = $request->file('document');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = 'document/'.$document->personal_data_id . '/' . $fileName; // Path file
                $file->move(public_path('upload/document/'.$document->personal_data_id), $fileName); // Pindahkan ke direktori public
                $document->path = $filePath;
            }

            // Simpan perubahan ke database
            $document->save();

            return response()->json(['success' => $this->namemodel . ' updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function destroy($id)
    {
        try {
            // Cari data berdasarkan ID
            $document = $this->model->findOrFail($id);

            // Hapus file fisik jika ada
            $filePath = public_path('upload/'.$document->path); // Lokasi file
            if ($document->path && file_exists($filePath)) {
                unlink($filePath); // Hapus file
            }

            // Hapus data dari database
            $document->delete();

            return response()->json(['success' => $this->namemodel . ' deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
