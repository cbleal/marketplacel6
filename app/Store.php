<?php

namespace App;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;

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
}
