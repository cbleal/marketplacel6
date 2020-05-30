@extends('layouts.app')

@section('content')

<a href="{{ route('admin.categories.create') }}" 
    class="btn btn-success mb-3">Nova Categoria</a>

<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>Nome</th>
            <th>Descrição</th>            
            <th class="text-center">Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td>
                    <a href="{{ route('admin.categories.show', ['category' => $category->id]) }}">
                        {{ $category->name }}
                    </a>
                </td>
                <td>{{ $category->description }}</td>                
                <td class="text-center">
                    <div class="btn-group">
                        <a href="{{ route('admin.categories.edit', ['category' => $category->id]) }}" 
                            class="btn btn-sm btn-primary">EDITAR</a>
                        <form action="{{ route('admin.categories.destroy', ['category' => $category->id]) }}"
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
        @endforeach
    </tbody>
</table>

{{ $categories->links() }}

@endsection
