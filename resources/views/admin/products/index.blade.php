@extends('layouts.app')

@section('content')

<a href="{{ route('admin.products.create') }}" 
    class="btn btn-success mb-3">Novo Produto</a>

<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>#</th>
            <th>Nome</th>
            <th>Price</th>
            <th class="text-center">Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>
                    <a href="{{ route('admin.products.show', ['product' => $product->id]) }}">
                        {{ $product->name }}
                    </a>
                </td>
                <td>R$ {{ number_format($product->price, 2, ',', '.') }}</td>
                <td class="text-center">
                    <div class="btn-group">
                        <a href="{{ route('admin.products.edit', ['product' => $product->id]) }}" 
                            class="btn btn-sm btn-primary">EDITAR</a>
                        <form action="{{ route('admin.products.destroy', ['product' => $product->id]) }}"
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

{{ $products->links() }}

@endsection