@extends('welcome')

@section('content')
    <div class="container">

        @if (Session::has('message'))
            <div class="container alert alert-success">
                {{ Session::get('message') }}
            </div>
        @endif

        <h1 class="text-center my-4">Bienvenidos</h1>

        @foreach ($posts as $post)
            <div class="card mb-4">
                <div class="card-header">
                    <h4>{{ $post->title }}</h4>
                    <p>{{ $post->content }}</p>
                    <small>Post Nro. {{ $post->id }} - Author: {{ $post->user->name }}</small>

                    <div class="d-flex justify-content-end ml-2">
                        <a href="{{ route('posts.show', ['post' => $post]) }}" class="btn btn-primary ml-2">Read more</a>

                        @can('update', $post)
                            <a href="{{ route('posts.edit', ['post' => $post]) }}" class="btn btn-secondary ml-2">Edit</a>
                        @endcan

                        @can('delete', $post)
                            <form action="{{ route('posts.destroy', ['post' => $post]) }}" method="POST">
                                @method('DELETE')
                                @csrf
                                <button class="btn btn-danger ml-2">Delete</button>
                            </form>
                        @endcan
                    </div>
                </div>
            </div>
        @endforeach

    </div>
@endsection
