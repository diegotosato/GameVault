@extends('layouts.admin')

@section('title', 'Modifica ' . $videogame->name)

@section('content')
    <div class="d-flex align-items-center mb-4 justify-content-between">
        <h2 class="mb-0">{{ $videogame->name }}</h2>
        <a href="{{ route('admin.videogames.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i>
        </a>
    </div>

    <div class="card text-center">

        <div class="" style="width: 100%; height: 500px;  overflow: hidden">
            <img src="{{ asset('storage/' . $videogame->image) }}" class="card-img-top" alt="{{ $videogame->image_alt }}">
        </div>

        <div class="card-body text-start d-flex flex-column gap-3">
            <div class="description">
                <h5 class="card-title">Descrizione:</h5>
                <p class="m-0">{{ $videogame->description }}</p>
            </div>

            <div class="consoles">
                <h5 class="card-title">Consoles:</h5>

                @foreach ($videogame->consoles as $console)
                    <span class="badge px-3 py-2"
                        style="background-color: {{ $console->color }}">{{ $console->name }}</span>
                @endforeach
            </div>

            <div class="genres">
                <h5 class="card-title">Generi:</h5>

                @foreach ($videogame->genres as $genres)
                    <span class="badge text-bg-secondary px-3 py-2">{{ $genres->name }}</span>
                @endforeach
            </div>

            <div class="developers">
                <h5 class="card-title">Sviluppatore:</h5>
                @foreach ($developer as $dev)
                    <span class="badge text-bg-info text-white px-3 py-2">{{ $dev->name }}</span>
                @endforeach
            </div>

            <div class="multiplayerModes">
                <h5 class="card-title">Modalità multiplayer:</h5>

                @foreach ($videogame->multiplayerModes as $multiModes)
                    <span class="badge text-bg-dark px-3 py-2">{{ $multiModes->name }}</span>
                @endforeach
            </div>
        </div>
        <div class="card-footer text-body-secondary">
            Data di rilascio: {{ $videogame->release_date->format('d-m-Y') }}
        </div>
    </div>
@endsection
