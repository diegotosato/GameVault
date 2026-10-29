@extends('layouts.admin')

@section('title', 'Sviluppatori')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Sviluppatori</h2>
        <a href="{{ route('admin.developers.create') }}" class="btn btn-primary">
            Aggiungi Sviluppatore
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
                    @forelse($developers as $developer)
                        <tr>
                            <td class="align-middle fw-semibold">{{ $developer->name }}</td>
                            <td class="align-middle text-muted"><code>{{ $developer->slug }}</code></td>
                            <td class="align-middle text-center">
                                <a href="{{ route('admin.developers.edit', $developer) }}"
                                    class="btn btn-sm btn-warning me-1">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.developers.destroy', $developer) }}" method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Eliminare \'{{ addslashes($developer->name) }}\'? I videogiochi associati verranno eliminati.')">
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
                                <i class="bi bi-inbox fs-3 d-block mb-2"></i>Nessuno sviluppatore presente.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
