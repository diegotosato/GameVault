@extends('layouts.admin')

@section('title', 'Modifica Genere')

@section('content')
    <div class="d-flex align-items-center mb-4 justify-content-between">
        <h2 class="mb-0">Modifica: {{ $genre->name }}</h2>
        <a href="{{ route('admin.genres.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i>
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.genres.update', $genre) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="name" class="form-label fw-semibold">Nome</label>
                    <input type="text" name="name" id="name"
                        class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $genre->name) }}"
                        required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        Salva Modifiche
                    </button>
                    <a href="{{ route('admin.genres.index') }}" class="btn btn-outline-secondary">Annulla</a>
                </div>
            </form>
        </div>
    </div>
@endsection
