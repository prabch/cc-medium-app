<?php

namespace App\Http\Controllers\API;

use Session;
use App\Models\User;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{

    public function register(RegisterRequest $request)
    {
        try {
            $user = new User();
            $user->name = $request->validated()['name'];
            $user->email = $request->validated()['email'];
            $user->password = Hash::make($request->validated()['password']);
            $user->save();

            $success = true;
            $message = 'Registration successful';
            $errors = [];

        } catch (\Illuminate\Database\QueryException $ex) {
            $success = false;
            $message = 'Error occured';
            $errors[] = $ex->getMessage();
        }

        return [
            'success' => $success,
            'message' => $message,
            'errors' => $errors
        ];
    }


    public function login(LoginRequest $request)
    {
        $credentials = [
            'email' => $request->validated()['email'],
            'password' => $request->validated()['password'],
        ];

        if (Auth::attempt($credentials)) {
            $profile = User::with('token')->find(Auth::id());
            if (isset($profile['token']['token'])) {
                $token = $profile['token']['token'];
                session(['token' => $token, 'medium_user_id' => $profile['token']['medium_user_id']]);
            }
            $success = true;
            $message = 'Logging you in...';
            $errors = [];
        } else {
            $success = false;
            $message = 'Unauthorised';
            $errors = ['auth' => 'Invalid login details'];
        }

        return [
            'success' => $success,
            'message' => $message,
            'errors' => $errors
        ];
    }

    public function logout()
    {
        Session::flush();
        return [
            'success' => true,
            'message' => 'Logged out',
            'errors' => []
        ];
    }
}