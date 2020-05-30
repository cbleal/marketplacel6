@extends('layouts.app')

@section('content')

@if (!$store)
    <a href="{{ route('admin.stores.create') }}" 
    class="btn btn-success mb-3">Nova Loja</a>
@else
<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>Loja</th>
            <th>Total de Produtos</th>
            <th class="text-center">Ações</th>
        </tr>
    </thead>
    <tbody>
        {{-- @foreach($stores as $store) --}}
            <tr>
                <td>{{ $store->id }}</td>
                <td>{{ $store->name }}</td>
                <td>{{ $store->products->count() }}</td>
                <td class="text-center">
                    <div class="btn-group">
                        <a href="{{ route('admin.stores.edit', ['store' => $store->id]) }}" 
                            class="btn btn-sm btn-primary">EDITAR</a>
                        <form action="{{ route('admin.stores.destroy', ['store' => $store->id]) }}"
                            method="POST">
                            @csrf
                            @method("DELETE")
                            <button type="submit" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Tem certeza que deseja excluir o item ?')">
                                EXCLUIR
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        {{-- @endforeach --}}
    </tbody>
</table>
@endif

{{-- {{ $stores->links() }} --}}

@endsection