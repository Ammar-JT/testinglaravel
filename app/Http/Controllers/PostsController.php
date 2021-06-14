<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function index($id){
        try{
            //$post = Post::find($id);
            $post = Post::findOrFail($id);
        }catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            //return 'asdf';
            abort(404, 'Page not found');
        }
        return view('post')->with('post', $post);
    }


    public function showAllPosts(){
        $posts = Post::all();
        return view('posts')->with('posts', $posts);
    }

    public function storePost(){
        $r = request();
        $this->validate($r, [
            'title' => 'required',
            'body' => 'required'
        ]);

        $post = Post::create([
            'title' => request()->title,
            'body' => request()->body
        ]);
    }
}
