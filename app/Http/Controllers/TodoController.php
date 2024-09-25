<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class TodoController extends Controller
{
    public function index() {
        $token = session('token');
        if($token) {
            $todo = Post::with('user')->get();
            return view('dashboard', ['todo' => $todo]);
        } else {
            return redirect('/');
        }
    }
}
