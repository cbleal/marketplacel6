<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductPhoto extends Model
{
    protected $fillable = ['image'];

    // LIGAR COM PRODUCT
    public function product()
    {
        // ESTA PHOTO PERTENCE A UM PRODUCT
        return $this->belongsTo(Product::class);
    }
}
