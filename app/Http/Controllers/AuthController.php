<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    // Register
    public function Register(Request $request)
    {
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'username' => 'required',
            'password' => 'required',
            'email' => 'required'
        ]);

        $hashedPwd = Hash::make($request->password);

        User::create([
            'name' => $request->username,
            'email' => $request->email,
            'password' => $hashedPwd
        ]);

        DB::table('agents')->insert([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email
        ]);

        return response(['data' => [$request->username]]);
    }

    // Login
    public function Login(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'email' => 'required',
        ]);

        $user = User::where('email', $request['email'])->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return response([
            'authToken' => $user->createToken($request->email)->plainTextToken,
            'username' => $user->name
        ]);
    }

    //Logout
    public function Logout(Request $request)
    {
    }
}
