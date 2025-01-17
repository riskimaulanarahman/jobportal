<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Models\PersonalData;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use DB;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */

     public function register(Request $request)
     {
         try {
             $validator = Validator::make($request->all(), [
                 'nik' => 'required|string|size:16',
                 'first_name' => 'required|string|max:255',
                 'last_name' => 'required|string|max:255',
                 'known_as' => 'required|string|max:255',
                 'gender' => 'required|string|in:male,female',
                 'place_of_birth' => 'required|string|max:255',
                 'date_of_birth' => 'required|date',
                 'marital_status' => 'required|string|in:single,married,divorced,widowed',
                 'email' => 'required|string|email|max:255|unique:users,email',
                 'whatsapp_number' => 'required|string|max:15|unique:personal_data,whatsapp_number',
                 'username' => 'required|string|max:255|unique:users,username',
                 'password' => 'required|string|min:8',
             ]);
     
             if ($validator->fails()) {
                 return response()->json([
                     'status' => 'validation_error',
                     'errors' => $validator->errors(),
                 ], 422);
             }
     
             DB::transaction(function () use ($request) {
                 // Create the user
                 $user = User::create([
                     'fullname' => "{$request->input('first_name')} {$request->input('last_name')}",
                     'username' => $request->input('username'),
                     'password' => Hash::make($request->input('password')),
                     'email' => $request->input('email'),
                 ]);
     
                if ($request->gender) {
                    $title = ($request->gender == 'male') ? 'Mr' : (($request->gender == 'female') ? 'Ms' : null);
                }
     
                 // Create personal data
                 PersonalData::create([
                     'user_id' => $user->id,
                     'nik' => $request->input('nik'),
                     'title' => $title,
                     'first_name' => $request->input('first_name'),
                     'last_name' => $request->input('last_name'),
                     'known_as' => $request->input('known_as'),
                     'gender' => $request->input('gender'),
                     'marital_status' => $request->input('marital_status'),
                     'marital_status_since' => $request->input('since') ?? null, // Optional field
                     'place_of_birth' => $request->input('place_of_birth'),
                     'date_of_birth' => $request->input('date_of_birth'),
                     'whatsapp_number' => $request->input('whatsapp_number'),
                 ]);
     
                 // Log in the user
                 auth()->login($user);
             });
     
             return response()->json([
                 'status' => 'success',
                 'message' => 'Pendaftaran berhasil!',
                 'redirect_url' => route('root'),
             ]);
         } catch (\Exception $e) {
             // Log the exception
             Log::error('Registration Error', [
                 'exception' => $e->getMessage(),
                 'trace' => $e->getTraceAsString(),
                 'request_data' => $request->except(['password']),
             ]);
     
             return response()->json([
                 'status' => 'error',
                 'message' => 'Terjadi kesalahan. Silakan coba lagi.',
             ], 500);
         }
     }

    // protected function validator(array $data)
    // {
    //     return Validator::make($data, [
    //         'name' => ['required', 'string', 'max:255'],
    //         'username' => ['required', 'string', 'max:255', 'unique:users'],
    //         'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
    //         'password' => ['required', 'string', 'min:8', 'confirmed'],
    //         'title' => ['required', 'string', 'max:255'],
    //         'first_name' => ['required', 'string', 'max:255'],
    //         'last_name' => ['required', 'string', 'max:255'],
    //         'known_as' => ['nullable', 'string', 'max:255'],
    //         'place_of_birth' => ['required', 'string', 'max:255'],
    //         'date_of_birth' => ['required', 'date'],
    //         'whatsapp_number' => ['nullable', 'string', 'max:255'],
    //     ]);
    // }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    // protected function create(array $data)
    // {
    //     // return request()->file('avatar');
    //     if (request()->has('avatar')) {
    //         $avatar = request()->file('avatar');
    //         $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
    //         $avatarPath = public_path('/images/');
    //         $avatar->move($avatarPath, $avatarName);
    //     }

    //     return User::create([
    //         'name' => $data['name'],
    //         'email' => $data['email'],
    //         'password' => Hash::make($data['password']),
    //         'avatar' =>  $avatarName,
    //     ]);
    // }

    // protected function create(array $data)
    // {
    //     // Create the user in the users table
    //     DB::transaction(function () {
    //         $user = User::create([
    //             'fullname' => $data['first_name'] . ' ' . $data['last_name'],
    //             'username' => $data['username'],
    //             'email' => $data['email'],
    //             'password' => Hash::make($data['password']),
    //         ]);

    //         // Insert additional personal data in the personal_data table
    //         PersonalData::create([
    //             'user_id' => $user->id,
    //             'title' => $data['title'],
    //             'first_name' => $data['first_name'],
    //             'last_name' => $data['last_name'],
    //             'known_as' => $data['known_as'],
    //             'place_of_birth' => $data['place_of_birth'],
    //             'date_of_birth' => $data['date_of_birth'],
    //             'whatsapp_number' => $data['whatsapp_number'],
    //         ]);
    //     });

    //     return $user;
    // }
}
