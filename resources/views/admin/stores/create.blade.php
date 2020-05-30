@extends('layouts.app')

@section('content')

<div class="jumbotron">
    <h1 class="display-4">Cadastro de Loja</h1>       
</div>

<form action="{{ route('admin.stores.store') }}" method="POST" enctype="multipart/form-data">

    @csrf

    <div class="form-group">
        <label for="name">Loja:</label>
        <input type="text" name="name" class="form-control 
            @error('name') is-invalid @enderror" value="{{ old('name') }}">
        
        @error('name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>

    <div class="form-group">
        <label for="description">Descrição:</label>
        <input type="text" name="description" class="form-control 
            @error('description') is-invalid @enderror" value="{{ old('description') }}">

        @error('description')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>

    <div class="form-group">
        <label for="phone">Telefone:</label>
        <input type="text" name="phone" id="phone" class="form-control 
            @error('phone') is-invalid @enderror" value="{{ old('phone') }}">

        @error('phone')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>

    <div class="form-group">
        <label for="mobile_phone">Celular/Whatsapp:</label>
        <input type="text" name="mobile_phone" id="mobile_phone" class="form-control 
            @error('mobile_phone') is-invalid @enderror"  value="{{ old('mobile_phone') }}">

        @error('mobile_phone')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
        
    </div>

    <div class="form-group">
        <label for="">Logo da Loja:</label>
        <input type="file" name="logo" class="form-control @error('logo') is-invalid @enderror">

        @error('logo')
            <div class="invalid-feddback">
                {{ $message }}
            </div>
        @enderror

    </div>

    {{-- <div class="form-group">
        <label for="slug">Slug:</label>
        <input type="text" name="slug" class="form-control">
    </div> --}}

    {{-- <div class="form-group">
        <label for="user">Usuário:</label>
        <select name="user" class="form-control">  
            @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
        </select>
    </div> --}}

    <div class="form-group">
        <button type="submit" class="btn btn-lg btn-success">Criar Loja</button>
    </div>

</form>

@endsection

@section('scripts')

<script>

    let imPhone = new Inputmask('(99) 9999-9999');
    imPhone.mask(document.getElementById('phone'));

    let imMobilePhone = new Inputmask('(99) 99999-9999');
    imMobilePhone.mask(document.getElementById('mobile_phone'));

</script>
    
@endsection