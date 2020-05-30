@extends('layouts.app')

@section('content')

<a href="{{ route('admin.products.index') }}">Voltar</a>

<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">

    @csrf

    <div class="form-group">
        <label for="name">Nome:</label>
        <input type="text" name="name" 
                class="form-control @error('name') is-invalid @enderror" 
                value="{{ old('name') }}">

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
                value="{{ old('description') }}">
        
        @error('description')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>

    <div class="form-group">
        <label for="body">Conteúdo:</label>
        <textarea name="body" cols="30" rows="10" class="form-control"></textarea>
    </div>

    <div class="form-group">
        <label for="price">Preço:</label>
        <input type="text" name="price" id="price"
                class="form-control @error('price') is-invalid @enderror" 
                value="{{ old('price') }}">

        @error('price')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>

    <div class="form-group">
        <label for="categories">Categorias:</label>
        <select name="categories[]" id="" class="form-control" multiple>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">
                    {{ $category->name }}
                </option>
            @endforeach
        </select>            
    </div>

    <div class="form-group">
        <label for="">Fotos do Produto:</label>
        <input type="file" name="photos[]" 
                class="form-control @error('photos.*') is-invalid @enderror" multiple>

        @error('photos')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
        
    </div>

    {{-- <div class="form-group">
        <label for="slug">Slug:</label>
        <input type="text" name="slug" class="form-control">
    </div> --}}

    {{-- <div class="form-group">
        <label for="store">Loja:</label>
        <select name="store" class="form-control">  
            @foreach($stores as $store)
                <option value="{{ $store->id }}">{{ $store->name }}</option>
            @endforeach
        </select>
    </div> --}}

    <div class="form-group">
        <button type="submit" class="btn btn-lg btn-success">Criar Produto</button>
    </div>

</form>

@endsection

@section('scripts')
    <script src="https://cdn.rawgit.com/plentz/jquery-maskmoney/master/dist/jquery.maskMoney.min.js"></script>
    <script>
        $('#price').maskMoney({allowNegative: false, thousands: '.', decimal: ','});
    </script>
@endsection