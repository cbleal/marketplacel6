@extends('layouts.app')

@section('content')


<a href="{{ route('admin.products.index') }}">Voltar</a>

<div class="col-sm-6">
    <h1>{{ $product->name }}
        <span class="pull-right">
            <a href="{{ route('admin.products.edit', ['product' => $product->id]) }}">
              <button type="button" class="btn btn-success">
                <span class="fa fa-pencil"></span>Editar
              </button>
            </a>
        <span>
    </h1>
</div>

<div class="col-sm-6">
    <table class="table table-user-information">   
        <tbody>           
            
            <tr>
                <th class="text-right">Descrição</th>           
                <td>{{ $product->description }}</td>
            </tr>
    
            <tr>
                <th class="text-right">Conteúdo</th>           
                <td>{{ $product->body }}</td>
            </tr>
    
            <tr>
                <th class="text-right">Preço</th>           
                <td>R$ {{ number_format($product->price, 2, ',', '.') }}</td>
            </tr>
    
            <tr>
                <th class="text-right">Slug</th>           
                <td>{{ $product->slug }}</td>
            </tr>     
           
        </tbody>
    </table>
</div>

@endsection