<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller implements HasMiddleware
{
    public static function middleware() {
        return [
            new Middleware('auth:sanctum', except: ['index', 'show', 'status'])
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Post::with('user')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'title'     => 'required|max:255',
            'body'   => 'required'
        ]);

        $post = $request->user()->posts()->create($fields);
        $todo = Post::all();
        return view('ajax.all')->with('todo', $todo)->render();
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('ajax.edit')->with('post', $post)->render();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        Gate::authorize('modify', $post);
        $fields = $request->validate([
            'title'     => 'required|max:255',
            'body'   => 'required'
        ]);

        $post->update($fields);
        $row = Post::with('user')->findOrFail($post->id);
        return view('ajax.update')->with('row', $row)->render();
    }

    /**
     * Update the specified resource in storage.
     */
    public function status(Request $request)
    {
        // Gate::authorize('modify', $post);
        $status = $request->status == 0 ? 1 : 0;
        Post::where('id', $request->id)->update([
            'status' => $status
         ]);
        $post = Post::find($request->id);
        return view('ajax.task')->with('row', $post)->render();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        Gate::authorize('modify', $post);
        $post->delete();
        return ['message' => 'Post was deleted'];
    }
}
