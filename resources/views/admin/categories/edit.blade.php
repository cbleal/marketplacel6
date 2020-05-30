@extends('layouts.app')

@section('content')

<a href="{{ route('admin.categories.index') }}">Voltar</a>

<form action="{{ route('admin.categories.update', ['category' => $category->id]) }}" method="POST">

    @method("PUT")
    @csrf

    <div class="form-group">
        <label for="name">Nome:</label>
        <input type="text" name="name" 
                class="form-control @error('name') is-invalid @enderror" 
                value="{{ $category->name }}">
        
        @error('name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>

    <div class="form-group">
        <label for="description">Descrição:</label>
        <input type="text" name="description" 
                class="form-control @error('description') is-invalid @enderror"  
                value="{{ $category->description }}">

        @error('description')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
        
    </div>   

    {{-- <div class="form-group">
        <label for="slug">Slug:</label>
        <input type="text" name="slug" class="form-control" value="{{ $category->slug }}">
    </div> --}}

    <div class="form-group">
        <button type="submit" class="btn btn-lg btn-success">Atualizar Categoria</button>
    </div>

</form>

@endsection