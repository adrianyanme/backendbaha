<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\PostDetailResource;
use Illuminate\Http\File;

class PostController extends Controller
{
    public function index ()
    {
        $posts = Post::all();
        return PostDetailResource::collection($posts->loadMissing(['writer:id,username,firstname,lastname', 'comments:id,post_id,user_id,comments_content']));
    }

    public function show($id)
    {
        $post = Post::with('writer:id,username,firstname,lastname')->findOrFail($id);
        return new PostDetailResource($post->loadMissing(['writer:id,username,firstname,lastname', 'comments:id,post_id,user_id,comments_content']));
    }

    public function store (Request $request)
    {
        // return $request->file;

        $validated = $request->validate([
            'title' => 'required|max:255',
            'news_content' => 'required',
        ]);

        $image=null;
        if ($request->file){
            $filename = $this->RandomString();
            $extension = $request->file->extension();
            $image =$filename.'.'.$extension;

            Storage::putFileAs('image', $request->file, $image);
        }

        $request['image'] = $image;
        $request['author'] = Auth::user()->id;
        $post = Post::create($request->all());
        return new PostDetailResource($post->loadMissing('writer:id,username'));
    }
    
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'news_content' => 'required',
        ]);
        $post = Post::findOrFail($id);
        $post->update($request->all());
        return new PostDetailResource($post->loadMissing('writer:id,username'));
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return new PostDetailResource($post->loadMissing('writer:id,username'));
    }

    function RandomString()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randstring = '';
        for ($i = 0; $i < 10; $i++) {
            $randstring = $characters[rand(0, strlen($characters))];
        }
        return $randstring;
    }
    //cek

}
