@extends('layouts.front')

@section('content')

<div class="row">
    
    <div class="col-12">
        <h2>Carrinho de Compras</h2>
        <hr>
        <div class="col-12">
            @if (session()->has('cart'))
                <table class="table table-striped">               
                    <thead>
                        <tr>
                            <th>Produto</th>
                            <th>Preço</th>
                            <th>Qtde</th>
                            <th>SubTotal</th>
                            <th>Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $total = 0;
                        @endphp
                        @foreach ($cart as $item)
                            <tr>
                                <td>{{ $item['name'] }}</td>
                                <td>R$ {{ number_format($item['price'], 2, ',', '.') }}</td>
                                <td>{{ $item['amount'] }}</td>
                                @php
                                    $subtotal = $item['price'] * $item['amount'];
                                    $total += $subtotal;
                                @endphp
                                <td>R$ {{ number_format($subtotal, 2, ',', '.') }}</td>
                                <td>
                                    <a href="{{ route('cart.remove', ['slug' => $item['slug']]) }}" class="btn btn-sm btn-danger">
                                        REMOVER
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="3">TOTAL:</td>
                            <td colspan="2">R$ {{ number_format($total, 2, ',', '.') }}</td>
                        </tr>
                    </tbody>                
                </table>
                <div class="col-12">
                    <a href="{{ route('checkout.index') }}" class="btn btn-lg btn-success float-right">Concluir Compra</a>
                    <a href="{{ route('cart.cancel') }}" class="btn btn-lg btn-danger float-left">Cancelar Compra</a>
                </div>
            @else
                <div class="alert alert-warning">Carrinho vazio...</div>
            @endif
        </div>
    </div>

</div>

@endsection