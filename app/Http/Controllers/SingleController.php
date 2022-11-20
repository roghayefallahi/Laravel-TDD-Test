<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class SingleController extends Controller
{
    public function index(Post $post)
    {
        $comments = $post->comments()->latest()->paginate(15);
        return view('single', compact('post', 'comments'));
    }

    public function createComment(Request $request, Post $post)
    {
        // dd($request->ajax());
        $request->validate([
            'text' => 'required'
        ]);
        
        $post->comments()->create([
            'user_id' => auth()->user()->id,
            'text' => $request->input('text')
        ]);

        return [
            'created' => true
        ];
    }
}
