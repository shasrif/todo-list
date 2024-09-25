<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function index() {
        $token = session('token');
        if($token) {
            return redirect('/dashboard');
        } else {
            return view('login');
        }
    }

    public function create() {
        return view('register');
    }

    public function register(Request $request) {
        $fields = $request->validate([
            'name'      => 'required|max:255',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|confirmed'
        ]);

        $user = User::create($fields);

        $token = $user->CreateToken($request->name);

        Session::put('token', $token->plainTextToken);
        Session::put('user_id', $user->id);
        Session::put('user_name', $user->name);
        return [
            'user'  => $user,
            'token' => $token->plainTextToken
        ];
    }

    public function login(Request $request) {
        $request->validate([
            'email'     => 'required|email|exists:users',
            'password'  => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if(!$user || !Hash::check($request->password, $user->password)) {
            return [
                'message'   => 'Provided credentials are in correct'
            ];
        }

        $token = $user->CreateToken($user->name);
        $request->session()->put('token', $token->plainTextToken); 
        $request->session()->put('user_id', $user->id); 
        $request->session()->put('user_name', $user->name); 
        return [
            'user'  => $user,
            'token' => $token->plainTextToken
        ];
    }

    public function logout(Request $request) {
        $request->user()->tokens()->delete();
        $request->session()->flush();
        return [
            'message'   => 'You are logged out'
        ];
    }
}
