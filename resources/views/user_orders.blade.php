@extends('layouts.front')

@section('content')

<div class="row">

    <div class="col-12">
        <h3>Meus Pedidos</h3>
        <hr>
    </div>

    <div class="col-12">

        <div id="accordion">

            @forelse ($userOrders as $key => $order)
                <div class="card">

                    <div class="card-header" id="headingOne">
                        <h5 class="mb-0">
                        <button class="btn btn-link" data-toggle="collapse" data-target="#collapse{{ $key }}" aria-expanded="true" aria-controls="collapseOne">
                                Pedido nº {{ $order->reference }}
                            </button>
                        </h5>
                    </div>
                
                    <div id="collapse{{ $key }}" class="collapse @if($key == 0) show @endif" aria-labelledby="headingOne" data-parent="#accordion">

                        <div class="card-body">
                            <ul>
                                @php $items = unserialize($order->items); @endphp
                                @foreach ($items as $item)
                                    <li>
                                        {{ $item['name'] }} | R$ {{ number_format($item['price'] * $item['amount'], 2, ',', '.') }}
                                        <br>
                                        Qtde: {{ $item['amount'] }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                    </div>

                </div>
            @empty
                <div class="col-12">
                    <h3 class="alert alert-warning">Nenhum pedido recebido.</h3>
                </div>
            @endforelse            
                      
        </div>

        {{ $userOrders->links() }}

    </div>

</div>

@endsection
