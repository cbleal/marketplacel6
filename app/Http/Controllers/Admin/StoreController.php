<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRequest;
use Illuminate\Support\Facades\Storage;
use App\Traits\UploadTrait;

class StoreController extends Controller
{
    use UploadTrait;

    /**
     * Construtor da classe
     * 
     * Adiciona um middleware à classe - Verifica se o usuário loja já tem uma loja
     * Classe: App\Http\Middleware\UserHasStoreMiddleware
     */
    public function __construct()
    {
        $this->middleware('user.has.store')->only(['create', 'store']);
    }

    /**
     * Exiba uma lista no recurso
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // recuperar todas as stores
        // $stores = \App\Store::all();
        
        // stores com paginação de 10 por página
        // $stores = \App\Store::paginate(10);

        // recuperar a store do user logado
        $store = auth()->user()->store;

        // manda para view index passando como parâmetros os stores
        // return view('admin.stores.index', compact('stores'));
        return view('admin.stores.index', compact('store'));
    }

    /**
     * Mostre o formulário para criar um novo recurso.
     * 
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // recuperar todos os usuários
        $users = \App\User::all();

        return view('admin.stores.create', compact('users'));
    }

    /**
     * Armazene um recurso recém-criado no armazenamento.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        // recupera todos os dados enviados do formulário
        $data = $request->all();    
        
        // salvar a loja com seu usuário correspondente
        // 1 - recupera o usuário do formulário
        // $user = \App\User::find($data['user']);
        // 2 - salvar na loja pelo seu método na classe User
        // $user->store()->create($data);

        $user = auth()->user();      
        
        if ($request->hasFile('logo')) {
            
            $data['logo'] = $this->imageUpload($request->file('logo'));
        }
        
        $user->store()->create($data);

        flash('Loja criada com sucesso')->success();
        return redirect()->route('admin.stores.index');
    }

    /**
     * Mostre o formulário para editar o recurso especificado.
     * 
     * @param  int  $store
     * @return \Illuminate\Http\Response
     */
    public function edit($store)
    {
        $store = \App\Store::find($store);

        return view('admin.stores.edit', compact('store'));
    }

    /**
     * Atualize o recurso especificado no armazenamento.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $store
     * @return \Illuminate\Http\Response
     */
    public function update(StoreRequest $request, $store)
    {
        $data = $request->all();

        $store = \App\Store::find($store);

        // VERIFICAR SE FOI ENVIADO ARQUIVO
        if ($request->hasFile('logo')) {
            // VERIFICA SE O ARQUIVO EXISTE
            if (Storage::disk('public')->exists($store->logo)) {
                // REMOVE
                Storage::disk('public')->delete($store->logo);
            }
            // ATUALIZA O ARQUIVO
            $data['logo'] = $this->imageUpload($request->file('logo'));
        }

        $store->update($data);

        flash('Loja atualizada com sucesso')->success();
        return redirect()->route('admin.stores.index');

    }

    /**
     * Remova o recurso especificado do armazenamento.
     *
     * @param  int  $store
     * @return \Illuminate\Http\Response
     */
    public function destroy($store)
    {
        $store = \App\Store::find($store);
        $store->delete();

        flash('Loja excluída com sucesso')->success();

        return redirect()->route('admin.stores.index');
    }
  
}
