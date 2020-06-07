<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index')->name('home');
Route::get('/product/{slug}', 'HomeController@single')->name('product.single');
Route::get('/category/{slug}', 'CategoryController@index')->name('category.single');

Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', 'CartController@index')->name('index');
    Route::post('add', 'CartController@add')->name('add');
    Route::get('remove/{slug}', 'CartController@remove')->name('remove');
    Route::get('cancel', 'CartController@cancel')->name('cancel');
});

Route::prefix('checkout')->name('checkout.')->group(function () {
    Route::get('/', 'CheckoutController@index')->name('index');
    Route::post('/process', 'CheckoutController@process')->name('process');
    Route::get('/thanks', 'CheckoutController@thanks')->name('thanks');

});


# ROTAS PARA LOJAS
// Route::get('admin/stores', 'Admin\\StoreController@index');  // lista
// Route::get('admin/stores/create', 'Admin\\StoreController@create'); // chama a view do formulário
// Route::post('admin/stores/store', 'Admin\\StoreController@store');  // salvar os dados

# MELHORANDO E ORGANIZANDO AS ROTAS PARA LOJAS = prefixo, namespace
# COLOCANDO AS ROTAS SOBRE AUTENTICAÇÃO


Route::get('my-orders', 'UserOrderController@index')->name('user.orders')->middleware('auth');

Route::group(['middleware' => ['auth', 'access.control.store.admin']], function () {    

    Route::prefix('admin')->name('admin.')->namespace('Admin')->group(function () {

        Route::get('notifications', 'NotificationController@notifications')->name('notifications.index');
        Route::get('notifications/read-all', 'NotificationController@readAll')->name('notifications.read.all');
        Route::get('notifications/read/{notification}', 'NotificationController@read')->name('notifications.read');

        Route::prefix('stores')->name('stores.')->group(function () {
    
            Route::get('/', 'StoreController@index')->name('index');
            Route::get('/create', 'StoreController@create')->name('create');
            Route::post('/store', 'StoreController@store')->name('store');
            Route::get('/{store}/edit', 'StoreController@edit')->name('edit');
            Route::put('/update/{store}', 'StoreController@update')->name('update');
            Route::delete('/destroy/{store}', 'StoreController@destroy')->name('destroy');
        });
    
        Route::resource('products', 'ProductController');
        Route::resource('categories', 'CategoryController');

        Route::post('photos/remove', 'ProductPhotoController@removePhoto')->name('photo.remove');

        Route::get('orders/my', 'OrdersController@index')->name('orders.my');
    
    });
});


// ACTIVE RECORD
//Route::get('model/', function () {
    // INSERIR
    // $user = new \App\User();
    
    // $user->name = 'Usuário Teste';
    // $user->email = 'email@teste.com';
    // $user->password = bcrypt('123456789');
    // $user->save();

    // return \App\User::all();

    // ALTERAR
    //     $user = new \App\User();
    //     $user = \App\User::find(1); // busca o registro com id=1
    //     $user->name = 'Usuário Teste Editado..';
    //     $user->save();

    //     return \App\User::all(); // Collection (converte para JSON)

    // });
 

// MASS ASSIGNMENT
// Route::get('model/', function () {
    // Insert
    // $user = \App\User::create([
    //     'name' => 'Claudinei Borges',
    //     'email' => 'email1000@gmail.com',
    //     'password' => bcrypt('123456789')
    // ]);
    // dd($user);
    // return \App\User::all();

    // Update
    // $user = \App\User::find(2);
    // $user->update([
    //     'name' => 'Atualizado com Mass Update'
    // ]);
    // dd($user);
    // return \App\User::all();


    // Como eu faria para pegar a loja de um usuario ?
    // $user = \App\User::find(1);
    // return $user->store;  // retorna um único objeto (hasOne, belongsTo)
    // dd($user->store());  // retorna uma instância
    // dd($user->store()->count());  // podemos utilizar funções na instância

    // Como eu faria para pegar os produtos de uma loja
    // $loja = \App\Store::find(1);
    // return $loja->products;  // retorna uma Collection (hasMany)
    // return $loja->products->count();  // retorna uma Collection
    // return $loja->products()->where('id', 1)->get();

    // Criar umma loja para um usuário
    // $user = \App\User::find(1);
    // $store = $user->store()->create([
    //     'name' => 'Loja Teste',
    //     'description' => 'Loja de Equipamentos e Suprimentos para Informática',
    //     'phone' => '(89) 3422-3388',
    //     'mobile_phone' => '(89) 99942-3456',
    //     'slug' => 'loja-teste'
    // ]);
    // dd($store);

    // Criar um produto para uma loja
    // $store = \App\Store::find(41);
    // $product = $store->products()->create([
    //     'name' => 'Notebook Dell',
    //     'description' => 'Intel Core i5/8G/1TB/15',
    //     'body' => 'Especificações técnicas aqui...',
    //     'price' => 3299,
    //     'slug' => 'notebook-dell'
    // ]);
    // dd($product);

    // Criar uma categoria    
    // \App\Category::create([
    //     'name' => 'Equipamentos',
    //     'description' => 'Produtos da área de equipamentos e eletrônicos',
    //     'slug' => 'equipamentos'
    // ]);
    // \App\Category::create([
    //     'name' => 'Força e Energia',
    //     'description' => 'Produtos da área de energia',
    //     'slug' => 'forca-e-energia'
    // ]);
 
    // Adicionar um produto para uma categoria ou vice-versa
    // $product = \App\Product::find(41);
    // dd($product->categories()->attach(1));  // add em category_product: 41 : 1
    // dd($product->categories()->attach(2));  // add em category_product: 41 : 2
    // dd($product->categories()->detach(1));  // remove em category_product: 41 : 1
    // dd($product->categories()->sync([2,3]));  // add em category_product: 41 : 2 - 41: 3
    // dd($product->categories()->sync([2]));  // remove em category_product: 41 : 3

    // return \App\Category::all();


// });

Auth::routes();  // ROTAS DE AUTENTICAÇÃO (login, logout, password-confirm, password-reset, register...)

Route::get('not', function() {

    // $user = \App\User::find(1);

    // CRIA NOTIFICAÇÃO
    // $user->notify(new \App\Notifications\StoreReceiverNewOrder);

    // LISTA NOTIFICAÇÕES
    // return $user->notifications;

    // LISTA NOTIFICAÇÕES NÃO LIDAS
    // return $user->unreadNotifications;

    // SELECIONA PRIMEIRA NOTIFICAÇÃO
    // $notification = $user->notifications->first();

    // MARCA COMO LIDA
    // $notification->markAsRead();

    // LISTA NOTIFICAÇÕES LIDAS
    // return $user->readNotifications;

    // QTDE DE NOTIFICAÇÕES
    // return $user->notifications->count();

    // $stores = [41, 49, 50];

    // $stores = \App\Store::whereIn('id', $stores)->get();

    // return $stores->each(function($store) {
    //     return $store->user;
    // });

});
