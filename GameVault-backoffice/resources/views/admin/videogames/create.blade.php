@extends('layouts.admin')

@section('title', 'Aggiungi Videogioco')

@section('content')
    <div class="d-flex align-items-center mb-4 justify-content-between">
        <h2 class="mb-0">Aggiungi Videogioco</h2>
        <a href="{{ route('admin.videogames.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i>
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('admin.videogames.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">

                    <div class="col-md-8">
                        <label for="name" class="form-label fw-semibold">Nome</label>
                        <input type="text" name="name" id="name"
                            class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="release_date" class="form-label fw-semibold">Data di Uscita </label>
                        <input type="date" name="release_date" id="release_date"
                            class="form-control @error('release_date') is-invalid @enderror"
                            value="{{ old('release_date') }}" required>
                        @error('release_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12">
                        <label for="description" class="form-label fw-semibold">Descrizione </label>
                        <textarea name="description" id="description" rows="3"
                            class="form-control @error('description') is-invalid @enderror" style="resize:none" required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="developer_id" class="form-label fw-semibold">Sviluppatore </label>
                        <select name="developer_id" id="developer_id"
                            class="form-select @error('developer_id') is-invalid @enderror" required>
                            <option value="">Seleziona sviluppatore</option>
                            @foreach ($developers as $dev)
                                <option value="{{ $dev->id }}" {{ old('developer_id') == $dev->id ? 'selected' : '' }}>
                                    {{ $dev->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('developer_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="image" class="form-label fw-semibold">Immagine Cover </label>
                        <input type="file" name="image" id="image"
                            class="form-control @error('image') is-invalid @enderror" accept="image/*" required>
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Generi</label>
                        <div class="border rounded p-2 d-flex flex-wrap">
                            @forelse($genres as $genre)
                                <div class="form-check w-50">
                                    <input class="form-check-input" type="checkbox" name="genres[]"
                                        value="{{ $genre->id }}" id="genre_{{ $genre->id }}"
                                        {{ in_array($genre->id, old('genres', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label"
                                        for="genre_{{ $genre->id }}">{{ $genre->name }}</label>
                                </div>
                            @empty
                                <p class="text-muted small mb-0">Nessun genere disponibile.</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Console</label>
                        <div class="border rounded p-2 d-flex flex-wrap">
                            @forelse($consoles as $console)
                                <div class="form-check w-50">
                                    <input class="form-check-input" type="checkbox" name="consoles[]"
                                        value="{{ $console->id }}" id="console_{{ $console->id }}"
                                        {{ in_array($console->id, old('consoles', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label"
                                        for="console_{{ $console->id }}">{{ $console->name }}</label>
                                </div>
                            @empty
                                <p class="text-muted small mb-0">Nessuna console disponibile.</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Modalità Multiplayer</label>
                        <div class="border rounded p-2 d-flex flex-wrap">
                            @forelse($multiplayerModes as $mode)
                                <div class="form-check w-50">
                                    <input class="form-check-input" type="checkbox" name="multiplayer_modes[]"
                                        value="{{ $mode->id }}" id="mode_{{ $mode->id }}"
                                        {{ in_array($mode->id, old('multiplayer_modes', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label"
                                        for="mode_{{ $mode->id }}">{{ $mode->name }}</label>
                                </div>
                            @empty
                                <p class="text-muted small mb-0">Nessuna modalità disponibile.</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="col-12 d-flex gap-2 mt-2">
                        <button type="submit" class="btn btn-primary">
                            Salva
                        </button>
                        <a href="{{ route('admin.videogames.index') }}" class="btn btn-outline-secondary">Annulla</a>
                    </div>

                </div>
            </form>
        </div>
    </div>
@endsection
