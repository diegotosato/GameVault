@extends('layouts.admin')

@section('title', 'Modalità Multiplayer')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Modalità Multiplayer</h2>
        <a href="{{ route('admin.multiplayer_modes.create') }}" class="btn btn-primary">
            Aggiungi Modalità
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
                    @forelse($modes as $mode)
                        <tr>
                            <td class="align-middle fw-semibold">{{ $mode->name }}</td>
                            <td class="align-middle text-muted"><code>{{ $mode->slug }}</code></td>
                            <td class="align-middle text-center">
                                <a href="{{ route('admin.multiplayer_modes.edit', $mode) }}"
                                    class="btn btn-sm btn-warning me-1">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.multiplayer_modes.destroy', $mode) }}" method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Eliminare \'{{ addslashes($mode->name) }}\'?')">
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
                                <i class="bi bi-inbox fs-3 d-block mb-2"></i>Nessuna modalità presente.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
