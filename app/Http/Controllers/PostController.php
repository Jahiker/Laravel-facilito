<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\PostFormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Redis;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // return response()->json([
        //     'status' => 'success',
        //     'text' => 'hola'
        // ]);

        // Para descarcar archivos
        // return response()->download($pathToFile);

        $posts = Post::orderBy('id', 'desc')->paginate(10);

        return view('post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostFormRequest $request, Post $post)
    {
        $post = new Post();

        $post->title = $request->input('title');
        $post->content = $request->input('content');
        $post->user_id = $request->user()->id;

        $post->save();

        return redirect()->route('posts.index')->with('message', 'Post publicado');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        $counter = 0;

        if(Redis::exists('post:view:'.$post->id)){
            Redis::incr('post:view:'.$post->id);
            $counter = Redis::get('post:view:'.$post->id);
        }else{
            Redis::set('post:view:'.$post->id, 0);
        }

        return view('post.show', compact('post', 'counter'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('post.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostFormRequest $request, Post $post)
    {
        // Usando Gate
        if(Gate::denies('delete-post', $post)){
            return redirect()->back();
        }

        // Usando el Modelo User
        // if(Auth::user()->cant('update', $post)){
        //     return redirect()->route('posts.my')
        //     ->with([
        //         'message' => 'No tienes permiso para editar este post'
        //     ]);
        // }

        // Usando Helper Controller
        $this->authorize('update', $post);

        $post->title  = $request->input('title');
        $post->content  = $request->input('content');

        $post->save();

        return redirect()->route('posts.edit', ['post' => $post])->with('message', 'Post actualizado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        // Usando el Modelo User
        if(Auth::user()->cant('delete', $post)){
            return redirect()->route('posts.my')
            ->with([
                'message' => 'No tienes permiso para eliminar este post'
            ]);
        }

        // Usando Helper Controller
        // $this->authorize('delete', $post);

        $post->delete();
        return redirect()->route('posts.index')->with('message', 'Post eliminado');
    }

    public function myPosts()
    {
        $posts = Auth::user()->posts;
        return view('post.my', compact('posts') );
    }
}
