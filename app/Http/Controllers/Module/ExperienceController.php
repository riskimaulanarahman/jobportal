<?php

namespace App\Http\Controllers\Module;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\Experience;

class ExperienceController extends Controller
{
    public function __construct()
    {
        $this->namemodel = 'Experience';
        $this->model = new Experience();
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'start_date'          => 'required|date',
                'end_date'            => 'nullable|date|after_or_equal:start_date',
                'company'             => 'required|string|max:255',
                'industry_type'       => 'required|string|max:255',
                'city_or_country'        => 'required|string|max:255',
                'last_position_held'       => 'required|string|max:255',
                'name_of_superior'       => 'required|string|max:255',
                'designation_of_superior'=> 'required|string|max:255',
                'last_drawn_salary'         => 'required|numeric|min:0',
                'reason_for_leaving'      => 'required|string|max:1000',
            ]);
            
            if ($validator->fails()) {
                // Gabungkan semua pesan error menjadi satu string
                $errors = implode('<br>', $validator->errors()->all());
                return response()->json(['error' => $errors]);
            }

            // Ambil nilai personal_data_id dari metode
            $personalDataId = $this->getPersonaldataByid();
            
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
                'start_date'          => 'required|date',
                'end_date'            => 'nullable|date|after_or_equal:start_date',
                'company'             => 'required|string|max:255',
                'industry_type'       => 'required|string|max:255',
                'city_or_country'        => 'required|string|max:255',
                'last_position_held'       => 'required|string|max:255',
                'name_of_superior'       => 'required|string|max:255',
                'designation_of_superior'=> 'required|string|max:255',
                'last_drawn_salary'         => 'required|numeric|min:0',
                'reason_for_leaving'      => 'required|string|max:1000',
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
