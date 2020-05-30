<?php

namespace App\Http\Controllers;

use App\Payment\PagSeguro\CreditCard;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        session()->forget('pagseguro_session_code');

        // SE O USUARIO NAO ESTIVER AUTENTICADO
        if (!auth()->check()) {
            # NÃO ESTANDO, O REDIRECIONAMENTO É FEITO PARA LOGIN
            return redirect()->route('login');
        }

        // SE NÃO EXISTIR SESSÃO COM CART, O REDIRECIONAMENTO É FEITO PARA HOME
        if (!session()->has('cart')) {
            return redirect()->route('home');
        }

        $this->makePagSeguroSession();
       
        $total = 0;

        $cartItems = array_map(function($line) {

            return $line['amount'] * $line['price'];
        }, session()->get('cart'));
        
        $cartItems = array_sum($cartItems);

        // var_dump(session()->get('pagseguro_session_code'));

        // return view('checkout');
        return view('checkout', compact('cartItems'));
    }

    private function makePagSeguroSession()
    {
        if (!session()->has('pagseguro_session_code')) {

            $sessionCode = \PagSeguro\Services\Session::create(
                \PagSeguro\Configuration\Configure::getAccountCredentials()
            );

            return session()->put('pagseguro_session_code', $sessionCode->getResult());
        }
    }

  
    public function process(Request $request)
    {
        try {

            $cartItems = session()->get('cart');
            $stores = array_unique(array_column($cartItems, 'store_id'));
            $user = auth()->user();
            $dataPost  = $request->all();
            $reference = 'XPTO';

            $creditCardPayment = new CreditCard($cartItems, $user, $dataPost, $reference);

            $result = $creditCardPayment->doPayment();

            // var_dump($result);

            $userOrder = [
                'reference' => $reference,
                'pagseguro_code' => $result->getCode(),
                'pagseguro_status' => $result->getStatus(),
                'items' => serialize($cartItems),                
            ];

            $userOrder = $user->orders()->create($userOrder);

            $userOrder->stores()->sync($stores);

            session()->forget('cart');
            session()->forget('pagseguro_session_code');

            return response()->json([
                'data' => [
                    'status' => true,
                    'message' => 'Pedido criado com sucesso.',
                    'order' => $reference
                ]
            ]);
        }
        catch(\Exception $e) {

            $message = env('APP_DEBUG') ? $e->getMessage() : 'Erro na criação do pedido.';
            return response()->json([
                'data' => [
                    'status' => false,
                    'message' => $message
                ]
            ], 401);
        }

    }

    public function thanks()
    {
        return view('thanks');
    }
    
}
