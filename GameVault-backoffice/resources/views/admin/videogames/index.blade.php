@extends('layouts.admin')

@section('title', 'Videogiochi')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Videogiochi</h2>
        <a href="{{ route('admin.videogames.create') }}" class="btn btn-primary">
            Aggiungi Videogioco
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th colspan="2">Nome</th>
                        <th>Sviluppatore</th>
                        <th>Data Uscita</th>
                        <th class="text-center">Azioni</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($games as $game)
                        <tr>
                            <td style="width: 150px">
                                <img src="{{ asset('storage/' . $game->image) }}" alt="{{ $game->image_alt }}"
                                    style="width:100%;height:62px;object-fit:cover;border-radius:4px">
                            </td>
                            <td class="align-middle fw-semibold">{{ $game->name }}</td>
                            <td class="align-middle text-muted">{{ $game->developer->name ?? '—' }}</td>


                            <td class="align-middle">{{ $game->release_date->format('d/m/Y') }}</td>
                            <td class="align-middle text-center">
                                <a href="{{ route('admin.videogames.show', $game) }}" class="btn btn-sm btn-info me-1">
                                    <i class="bi bi-eyeglasses"></i>
                                </a>
                                <a href="{{ route('admin.videogames.edit', $game) }}" class="btn btn-sm btn-warning me-1">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.videogames.destroy', $game) }}" method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Eliminare \'{{ addslashes($game->name) }}\'?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-5">
                                <i class="bi bi-inbox fs-3 d-block mb-2"></i>Nessun videogioco presente.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3 d-flex justify-content-center">
        {{ $games->links('pagination::bootstrap-5') }}
    </div>
@endsection
