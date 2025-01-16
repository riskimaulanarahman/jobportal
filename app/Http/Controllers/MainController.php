<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Models\Employee;
use App\Models\User;
use App\Models\Session;

class MainController extends Controller
{
    private $employee;
    private $user;
    private $session;

    public function __construct()
    {
        $this->employee = new Employee();
        $this->user = new User();
        $this->session = new Session();
    }

    public function getlogin(Request $request)
    {
        $username = $request->username;
        $password = $request->password;
        $user = $this->user->where('username',$username)->first();
        if($user !== null) {
            if(Hash::check($password, $user->password)) {
                    $this->user->where('username',$username)->update([
                        'password' => Hash::make($request->password)
                        // 'passtxt' => $request->password
                    ]);
                    $data['code'] = 200; // success
            } else {
                $data['code'] = 401; // unauthorized
            }
        } else {
            $data['code'] = 0; // user not found
        }

        $result = (object) $data;

        return response()->json($result);
    }
}
