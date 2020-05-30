@extends('layouts.app')

@section('content')


<a href="{{ route('admin.categories.index') }}">Voltar</a>

<div class="col-sm-6">
    <h1>{{ $category->name }}
        <span class="pull-right">
            <a href="{{ route('admin.categories.edit', ['category' => $category->id]) }}">
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
                <td>{{ $category->description }}</td>
            </tr>
    
            <tr>
                <th class="text-right">Slug</th>           
                <td>{{ $category->slug }}</td>
            </tr>     
           
        </tbody>
    </table>
</div>

@endsection