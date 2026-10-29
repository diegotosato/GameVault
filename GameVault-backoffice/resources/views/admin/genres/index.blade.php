@extends('layouts.admin')

@section('title', 'Generi')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Generi</h2>
        <a href="{{ route('admin.genres.create') }}" class="btn btn-primary">
            Aggiungi Genere
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Nome</th>
                        <th>Slug</th>
                        <th class="text-center">Azioni</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($genres as $genre)
                        <tr>
                            <td class="align-middle fw-semibold">{{ $genre->name }}</td>
                            <td class="align-middle text-muted"><code>{{ $genre->slug }}</code></td>
                            <td class="align-middle text-center">
                                <a href="{{ route('admin.genres.edit', $genre) }}" class="btn btn-sm btn-warning me-1">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.genres.destroy', $genre) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Eliminare \'{{ addslashes($genre->name) }}\'?')">
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
                            <td colspan="3" class="text-center text-muted py-5">
                                <i class="bi bi-inbox fs-3 d-block mb-2"></i>Nessun genere presente.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
