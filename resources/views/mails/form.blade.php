@extends('layouts.app')

@section('content')
<div class="container">

    @if (Session::has('message'))
        <div class="container alert alert-success">
            {{ Session::get('message') }}
        </div>
    @endif

    <form action="{{ route('sent') }}" method="POST">
        @csrf
        <div class="row justify-content-center">
            <div class="col-sm-8">
                <div class="form-group">
                    <label for="title">Nombre</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Nombre" value="{{ old('name') }}">
                    @error('name')
                        <strong class="text-danger text-bold mt-2">{{$message}}</strong>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="title">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="Correo electronico" value="{{ old('email') }}">
                    @error('email')
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
@endsection
