<?php

namespace App\Http\Controllers\Module;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use DB;
use Log;

use App\Models\PersonalData;
use App\Models\SocialMedia;
use App\Models\Size;
use App\Models\Family;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $personalInfo = PersonalData::where('user_id',$user->id)->first(); // This assumes you want the first record
        $socialMedia = SocialMedia::where('personal_data_id',$personalInfo->id)->get(); // This assumes you want the first record
        $size = Size::where('personal_data_id',$personalInfo->id)->get(); // This assumes you want the first record
        $family = Family::where('personal_data_id',$personalInfo->id)->get(); // This assumes you want the first record
        
        return view('area.my-profile', compact([
            'personalInfo',
            'socialMedia',
            'size',
            'family',
        ]));
    }

    public function update(Request $request, $id)
    {
        try {
            // Find the personal data by ID
            $personalInfo = PersonalData::findOrFail($id);
            // Validate the request data
            $validator = Validator::make($request->all(), [
                'nik' => 'required|string|min:16',
                'title' => 'nullable|string|max:5',
                'first_name' => 'required|string|max:50',
                'last_name' => 'required|string|max:50',
                'known_as' => 'required|string|max:20',
                'gender' => 'required|string|max:10',
                'date_of_birth' => 'required|date',
                'place_of_birth' => 'required|string|max:50',
                'country_of_birth' => 'required|string|max:50',
                'marital_status' => 'required|string|max:20',
                'nationality' => 'required|string|max:50',
                'language' => 'required|string|max:20',
                'religion' => 'required|string|max:20',
                'ethnic' => 'required|string|max:20',
                'blood_type' => 'required|in:A,B,AB,O',
                // 'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
                'profile_photo' => !empty($personalInfo->profile_photo) ? 'nullable|image|mimes:jpeg,png,jpg|max:2048' : 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);
    
            if ($validator->fails()) {
                return redirect()->route('my-profile.index')
                    ->withErrors($validator)
                    ->withInput();
            }
    
            $validatedData = $validator->validated();
            
            // Check the gender and set the default title if not provided
            if ($request->gender) {
                $validatedData['title'] = ($request->gender == 'male') ? 'Mr' : (($request->gender == 'female') ? 'Ms' : null);
            }
    
            // Check if a profile photo was uploaded
            if ($request->hasFile('profile_photo')) {
                // Store the file and get the path
                $filePath = $request->file('profile_photo')->store('profile', 'public');
    
                // Update the profile photo URL field
                $validatedData['profile_photo'] = $filePath;
            }
    
            // Update the personal information
            $personalInfo->update($validatedData);
    
            // Redirect back with a success message
            return redirect()->route('my-profile.index')->with('success', 'Profile updated successfully.');
        } catch (\Exception $e) {
    
            // Redirect back with an error message
            return redirect()->route('my-profile.index')->withErrors('An error occurred while updating the profile.');
        }
    }

}
