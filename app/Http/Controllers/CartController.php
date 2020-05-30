<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {

        $cart = session()->has('cart') ? session()->get('cart') : [];
        
        return view('cart', compact('cart'));
    }

    public function add(Request $request)
    {
        // RECUPERA O PRODUCT ENVIADO DO FORMULARIO SINGLE
        $productData = $request->get('product');

        // RECUPERA O PRODUCT DO BANCO QUE CONTÉM O MESMO SLUG
        $product = \App\Product::whereSlug($productData['slug']);

        // VERIFICAÇÃO DE SEGURANÇA
        // SE HOUVER ALTERAÇÃO NO SLUG OU AMOUNT MENOR IGUAL A ZERO, REDIRECIONA PARA HOME
        if (!$product->count() || $productData['amount'] <= 0) {
            return redirect()->route('home');
        }

        $product = array_merge($productData, 
            $product->first(['name', 'price', 'store_id'])->toArray());

        // VERIFICAR SE EXISTE UM CART NA SESSÃO
        if (session()->has('cart')) {
            // VERIFICAR SE O PRODUCT EXISTE NO CART
            // 1 - RECUPERA OS PRODUCTS DO CART
            $products = session()->get('cart');
            // 2 - RECUPERA OS SLUGS
            $productSlugs = array_column($products, 'slug');

            // VERIFICAR SE EXISTE UM PRODUCT COM MESMO SLUG
            if (in_array($product['slug'], $productSlugs)) {
                // EXISTINDO EU INCREMENTO A SUA QTDE ATRAVÉS DO MÉTODO PRODUCTINCREMENT
                $products = $this->productIncrement($product['slug'], $product['amount'], $products);
                // RECRIA A SESSÃO CART COM ESTE PRODUCT
                session()->put('cart', $products);
            }
            // SE NÃO EXISTIR UM PRODUTO COM MESMO SLUG
            else {

                // ADICIONO ESTE PRODUTO NA SESSÃO
                session()->push('cart', $product);
            }

        // NÃO EXISTINDO EU CRIO A SESSÃO CART COM ESTE PRODUTO
        } else {
            $products[] = $product;
            session()->put('cart', $products);
        }

        flash('Produto adicionado com sucesso.')->success();
        return redirect()->route('product.single', ['slug' => $product['slug']]);
    }

    public function remove($slug)
    {
        if (!session()->has('cart')) {
            return redirect()->route('cart.index');
        }

        $products = session()->get('cart');

        $products = array_filter($products, function($line) use($slug) {
            return $line['slug'] != $slug;
        });

        session()->put('cart', $products);

        flash('Produto removido com sucesso.')->success();
        return redirect()->route('cart.index');
    }

    public function cancel()
    {
        session()->forget('cart');

        flash('Desistência da compra realizada com sucesso.')->success();
        return redirect()->route('cart.index');
    }

    private function productIncrement($slug, $amount, $products)
    {
        $products = array_map(function($line) use($slug, $amount) {
            if ($slug == $line['slug']) {
                $line['amount'] += $amount;
            }
            return $line;
        }, $products);
    
	    return $products;
    }

}
