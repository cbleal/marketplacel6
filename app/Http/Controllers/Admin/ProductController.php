<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \App\Http\Requests\ProductRequest;
use App\Product;
use App\Traits\UploadTrait;

class ProductController extends Controller
{
    // use UploadTrait;

    private $product;

    /**
     * Construtor da classe
     * 
     * @return \App\Product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {        
        $user = auth()->user();

        if (!$user->store()->exists()) {
            flash('É preciso criar uma loja para acessar produtos.')->warning();
            return redirect()->route('admin.stores.index');
        }
       
        // LISTA OS PRODUTOS ESPECÍFICOS DESTA LOJA
        $products = $user->store->products()->orderBy('id', 'DESC')->paginate(10); 
        
        // MANDA PARA VIEW INDEX PASSANDO COMO PARÂMETRO OS PRODUCTS
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {        
        // RECUPERA TODAS AS STORES PARA PREENCHER O COMBO DO FORMULARIO
        // $stores = \App\Store::all('id', 'name');
        
        // MANDA PARA VIEW CREATE PASSANDO COMO PARÂMETRO AS STORES
        // return view('admin.products.create', compact('stores'));
        
        // RECUPERA TODAS AS CATEGORIES
        $categories = \App\Category::all(['id', 'name']);

        // MANDA PARA VIEW CREATE PASSANDO COMO PARÂMETRO AS CATEGORIES
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {        
        // dd($request->file('photos'));        

        // RECEBE OS VALORES DOS CAMPOS DO FORMULÁRIO CREATE DE PRODUCTS
        $data = $request->all();
        
        // RECUPERA O VALOR DO CAMPO CATEGORIES DO FORMULARIO OU NULO SE NÃO VIER NADA
        $categories = $request->get('categories', null);

        // RECUPERA A STORE DOS DADOS ENVIADOS
        // $store = \App\Store::find($data['store']);

        // CRIA O PRODUTO ATRAVÉS DO MÉTODO PRODUCTS DO RELACIONAMENTO COM A STORE
        // $product = $store->products()->create($data);

        // RECUPERA A STORE DO USER AUTENTICADO
        $store = auth()->user()->store;

        // FORMATAR O PRICE PARA SALVAR NO DATABASE
        $data['price'] = formatPriceToDatabase($data['price']);

        // CRIA O PRODUTO ATRAVÉS DO MÉTODO PRODUCTS DO RELACIONAMENTO COM A STORE
        $product = $store->products()->create($data);

        // SALVA AS CATEGORIES E PRODUCTS NA TABELA PIVOT ATRAVÉS DA LIGAÇÃO DE PRODUCTS COM CATEGORIES        
        $product->categories()->sync($categories);

        // VERIFICA SE FOI ENVIADO ARQUIVOS DE PHOTOS
        if ($request->hasFile('photos')) {
            // RECEBE AS PHOTOS DO MÉTODO IMAGEUPLOAD
            $images = $this->imageUpload($request, 'image');               
            // SALVA AS PHOTOS COM O MÉTODO PHOTO() DA LIGAÇÃO COM PRODUCT            
            $product->photos()->createMany($images);
        }

        // EXIBE A MENSAGEM
        flash('Produto criado com sucesso.');
        // REDIRECIONA PARA VIEW INDEX DE PRODUCTS
        return redirect()->route('admin.products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {                 
        // MANDA PARA VIEW SHOW O OBJETO PRODUCT RECEBIDO NO PARÂMETRO DO MÉTODO
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($product)
    {
        // RECUPERA UM PRODUCT ATRAVÉS DO SEU ID RECEBIDO POR PARÂMETRO DO MÉTODO
        $product = $this->product->find($product);

        // RECUPERA AS CATEGORIES
        $categories = \App\Category::all(['id', 'name']);
        
        // MANDA PARA VIEW EDIT OS OBJETOS PRODUTO E CATEGORIES
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $product
     * @param  Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Product $product, ProductRequest $request)
    {
        // RECUPERA TODOS OS VALORES DOS CAMPOS DO FORMULARIO EDIT DE PRODUCTS
        // $data = $request->all();

        // RECUPERA O PRODUCT PELO PARÂMETRO $PRODUCT (ID)
        // $product = $this->product->find($product);

        // ATUALIZA O PRODUCT
        // $product->update($data);

        // ATUALIZA O OBJETO PRODUCT ENVIADO POR PARÂMETRO DO MÉTODO COM OS VALORES
        // ENVIADOS DO FORMULARIO
        $product->update($request->all());

        // RECUPERA O VALOR DO CAMPO CATEGORIES DO FORMULARIO OU NULO SE NÃO VIER NADA
        $categories = $request->get('categories', null);

        // SE CATEGORIES NÃO VIER NULO
        if (!is_null($categories)) {

            // SALVA AS CATEGORIES E PRODUCTS NA TABELA PIVOT ATRAVÉS DA LIGAÇÃO DE PRODUCT E CATEGORY
            $product->categories()->sync($categories);
        }        

        if ($request->hasFile('photos')) {

            $images = $this->imageUpload($request, 'image');
            $product->photos()->createMany($images);
        }
 
        // EXIBE UMA MENSAGEM
        flash('Produto atualizado com sucesso.');
        // REDIRECIONA PARA VIEW INDEX DE PRODUCTS
        return redirect()->route('admin.products.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($product)
    {
        // RECUPERA O PRODUCT ATRAVÉS DO PARÂMETRO $PRODUCT (ID) DO MÉTODO 
        $product = $this->product->find($product);
        // REMOVE
        $product->delete();

        // EXIBE UM MENSAGEM
        flash('Produto excluído com sucesso.');
        // REDIRECIONA PARA VIEW INDEX DE PRODUCTS
        return redirect()->route('admin.products.index');
    }

    public function imageUpload(Request $request, $imageColumn = null)
    {
        
        $images = $request->file('photos');       

        $uploadedPhotos = [];            
          
        foreach ($images as $image) {
               
            $uploadedPhotos[] = [$imageColumn => $image->store('products', 'public')];
        }
        
        return $uploadedPhotos;
     
    }
}
