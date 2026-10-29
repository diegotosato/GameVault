@extends('layouts.admin')

@section('title', 'Console')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Console</h2>
        <a href="{{ route('admin.consoles.create') }}" class="btn btn-primary">
            Aggiungi Console
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>Nome</th>
                        <th>Slug</th>
                        <th>Colore</th>
                        <th class="text-center">Azioni</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($consoles as $console)
                        <tr>
                            <td class="align-middle fw-semibold">{{ $console->name }}</td>
                            <td class="align-middle text-muted"><code>{{ $console->slug }}</code></td>
                            <td class="align-middle">
                                <span class="d-inline-block rounded me-2"
                                    style="width:20px;height:20px;background:{{ $console->color }};border:1px solid #ccc;vertical-align:middle"></span>
                                {{ $console->color }}
                            </td>
                            <td class="align-middle text-center">
                                <a href="{{ route('admin.consoles.edit', $console) }}" class="btn btn-sm btn-warning me-1">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.consoles.destroy', $console) }}" method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Eliminare \'{{ addslashes($console->name) }}\'?')">
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
                            <td colspan="4" class="text-center text-muted py-5">
                                <i class="bi bi-inbox fs-3 d-block mb-2"></i>Nessuna console presente.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
