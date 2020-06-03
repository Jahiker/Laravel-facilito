@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-8 card">
                <div class="card-header">
                    <h3 class="card-title">Mensaje Nuevo de {{ $name }}</h3>
                </div>
                <div class="card-body">
                    <h2>Mensaje: </h2>
                    <p class="card-text">
                        {{ $content }}
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection
