@extends('layouts.front')

@section('stylesheets')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endsection

@section('content')

<div class="container">

    <div class="col-md-6">

        <hr>

        <form action="" method="POST">

            <div class="row">
                <div class="col-md-12 form-group">
                    <label>Nome no Cartão:</label>
                    <input type="text" name="card_name" class="form-control">                    
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12 form-group">
                    <label>Número do Cartão: <span class="brand"></span></label>
                    <input type="text" name="card_number" class="form-control">
                    <input type="hidden" name="card_brand">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 form-group">
                    <label for="">Mês de Expiração:</label>
                    <input type="text" class="form-control" name="card_month">
                </div>
           
                <div class="col-md-6 form-group">
                    <label for="">Ano de Expiração:</label>
                    <input type="text" class="form-control" name="card_year">
                </div>
            </div>
            
            <div class="row">            
                <div class="col-md-6 form-group">
                    <label for="">Código de Segurança:</label>
                    <input type="text" class="form-control" name="card_cvv">
                </div>
            </div>

            <div class="col-md-12 installments form-group"></div>

            <button class="btn btn-lg btn-success processCheckout">Efetuar Pagamento</button>

        </form>

    </div>

</div>

@endsection

@section('scripts')

    <script src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>
    
    {{-- <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script> --}}
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    {{-- <script src="{{ asset('assets/js/jquery.ajax.js') }}"></script> --}}

    <script>
        const sessionId = '{{ session()->get('pagseguro_session_code') }}';
        const urlThanks = '{{ route('checkout.thanks') }}';
        const amountTransaction = '{{$cartItems}}';
        const urlProcess = '{{ route("checkout.process") }}';
        const csrf = '{{ csrf_token() }}';

        PagSeguroDirectPayment.setSessionId(sessionId);
    </script>

    <script src="{{ asset('js/pagseguro_functions.js') }}"></script>
    <script src="{{ asset('js/pagseguro_events.js') }}"></script>

@endsection
