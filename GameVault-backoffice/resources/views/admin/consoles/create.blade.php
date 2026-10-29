@extends('layouts.admin')

@section('title', 'Aggiungi Console')

@section('content')
    <div class="d-flex align-items-center mb-4 justify-content-between">
        <h2 class="mb-0">Aggiungi Console</h2>
        <a href="{{ route('admin.consoles.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i>
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.consoles.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Nome</label>
                    <input type="text" name="name" id="name"
                        class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="color" class="form-label fw-semibold">Colore</label>
                    <div class="d-flex align-items-center gap-2">
                        <input type="color" name="color" id="color"
                            class="form-control form-control-color @error('color') is-invalid @enderror"
                            value="{{ old('color', '#000000') }}" required>
                        <small class="text-muted">Scegli il colore della console (hex)</small>
                    </div>
                    @error('color')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        Salva
                    </button>
                    <a href="{{ route('admin.consoles.index') }}" class="btn btn-outline-secondary">Annulla</a>
                </div>
            </form>
        </div>
    </div>
@endsection
