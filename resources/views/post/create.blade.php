@extends('layouts.app')

@section('content')
    <div class="container">

        <form action="{{route('posts.store')}}" method="POST">
            @csrf
            <div class="row justify-content-center">
                <div class="col-sm-8">
                    <div class="form-group">
                        <label for="title">Titulo</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" id="title" placeholder="Titulo" value="{{ old('title') }}">
                        @error('title')
                            <strong class="text-danger text-bold mt-2">{{$message}}</strong>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="title">Contenido</label>
                        <textarea name="content" class="form-control @error('content') is-invalid @enderror" id="content" cols="30" rows="10">{{ old('content') }}</textarea>
                        @error('content')
                            <strong class="text-danger text-bold mt-2">{{$message}}</strong>
                        @enderror
                    </div>

                </div>
                <div class="col-sm-8 text-center">
                    <button class="btn btn-primary btn-block" type="submit">Enviar</button>
                </div>
            </div>
        </form>

    </div>
@endsection
