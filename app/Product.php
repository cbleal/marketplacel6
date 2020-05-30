<?php

namespace App;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasSlug;

    protected $fillable = ['name', 'description', 'body', 'price', 'slug'];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    // FUNÇÃO QUE INDICA QUE ESTA CLASSE TEM UM RELACIONAMENTO DE 1:N COM A CLASSE STORE
    public function store()
    {
        return $this->belongsTo(Store::class);  // este produto pertence a uma loja
    }

    // FUNÇÃO QUE INDICA QUE ESTA CLASSE TEM UM RELACIONAMENTO DE N:N COM A CLASSE CATEGORIA
    public function categories()
    {
        return $this->belongsToMany(Category::class);  // este produto pertence a muitas categorias
    }

    // LIGAR COM PRODUCTPHOTO
    public function photos()
    {
        // ESTE PRODUCT TEM MUITAS PHOTOS
        return $this->hasMany(ProductPhoto::class);
    }
}
