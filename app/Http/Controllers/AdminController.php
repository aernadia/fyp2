<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Facades\Gate;

class AdminController extends Controller

{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        if(!\Auth::user()->hasRole('admin')){
            $posts = Post::where('userId', \Auth::user()->id)->orderBy('id', 'desc')
            ->get();
            
        }else{
            $posts = Post::orderBy('id', 'desc')->get();
        }

        return view('admin.index', ['posts' => $posts]);

    }
    

   
    public function create()
    {
        $this->authorize('create', Post::class);
        return view('admin.posts.create');
    }

    public function store(Request $request)
    {
        //validate the field
        $data = request()->validate([
            'title' => 'required|max:255',
            'post_content' => 'required'

        ]);


        $user = auth()->user();
        $post = new Post();

        $post->title = request('title');
        $post->content = request('post_content');
        // $post->image_url = $newFileName;
        $post->userId = $user->id;

        $post->save();

        return redirect('/posts')->with('success', 'Post Created Successfully!');
    }

   
    public function show(Request $request, Post $post)
    {
        if (\Request::ajax()){

            $post = Post::find($request['task']['id']);
            $post->published = $request['task']['checked'];
            $post->save();

            return $request;
        }

        return view('admin.posts.show', ['post'=>$post]);
    }

   
    public function edit(Post $post)
    {
        $this->authorize('edit', $post);

        $post = Post::find($post->id);

        // return view
        return view('admin/posts/edit', ['post' => $post]);
    }

  
    public function update(Request $request, Post $post)
    {

        $this->authorize('update', $post);

        $data = request()->validate([
            'title' => 'required|max:255',
            'image' => 'required|image',
            'post_content' => 'required'

        ]);


        $post = Post::findOrFail($post->id);

        $post->title = request('title');
        $post->content = request('post_content');


        $post->save();

        return redirect('/posts');
    }


    public function destroy(Post $post, Request $request)
    {
        
        //find the post
        $post = Post::find($request->post_id);
        
        $this->authorize('delete', $post);


        //delete the post
        $post->delete();

        //redirect to posts
        return redirect('/posts');
    }
}


