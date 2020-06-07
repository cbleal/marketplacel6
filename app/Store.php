<?php

namespace App;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;
use \App\Notifications\StoreReceiverNewOrder;

class Store extends Model
{
    use HasSlug;

    protected $fillable = ['name', 'description', 'phone', 'mobile_phone', 'slug', 'logo'];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    // FUNÇÃO QUE INDICA QUE ESTA CLASSE TEM UM RELACIONAMENTO 1:1 COM A CLASSE USER
    public function user()
    {
        return $this->belongsTo(User::class);  // uma loja pertence a um usuário
    }

    // FUNÇÃO QUE INDICA QUE ESTA CLASSE TEM UM RELACIONAMENTO DE 1:N COM A CLASSE PRODUCT
    public function products()
    {
        return $this->hasMany(Product::class);  // esta loja tem muitos produtos
    }

    public function orders()
    {
        return $this->belongsToMany(UserOrder::class);
    }

    public function notifyStoreOwners(array $storesId = [])
    {
        // RECUPERA AS LOJAS PELOS IDS PASSADOS POR PARÂMETRO DO MÉTODO
        $stores = $this->whereIn('id', $storesId)->get();

        // RECUPERA O USUÁRIO DA LOJA
        return $stores->map(function($store) {
            return $store->user;
            // CADA USUÁRIO É NOTIFICADO
        })->each->notify(new StoreReceiverNewOrder());
    }
}
