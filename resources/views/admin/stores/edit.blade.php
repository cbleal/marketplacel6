@extends('layouts.app')

@section('content')

<div class="jumbotron">
    <h1 class="display-4">Atualizar Loja</h1>       
</div>

<form action="{{ route('admin.stores.update', ['store' => $store->id]) }}" 
        method="POST" enctype="multipart/form-data">

    @method("PUT")
    @csrf

    <div class="form-group">
        <label for="name">Loja:</label>
        <input type="text" name="name" class="form-control" value="{{ $store->name }}">
    </div>

    <div class="form-group">
        <label for="description">Descrição:</label>
        <input type="text" name="description" class="form-control" 
                value="{{ $store->description }}">
    </div>

    <div class="form-group">
        <label for="phone">Telefone:</label>
        <input type="text" name="phone" id="phone" 
                class="form-control" value="{{ $store->phone }}">
    </div>

    <div class="form-group">
        <label for="mobile_phone">Celular/Whatsapp:</label>
        <input type="text" name="mobile_phone" id="mobile_phone" 
                class="form-control" value="{{ $store->mobile_phone }}">
    </div>

    <div class="form-group">
        <p>
            <img src="{{ asset('storage/' . $store->logo) }}" alt="">
        </p>
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
        <input type="text" name="slug" class="form-control" value="{{ $store->slug }}">
    </div> --}}

    <div class="form-group">
        <button type="submit" class="btn btn-lg btn-success">Atualizar Loja</button>
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