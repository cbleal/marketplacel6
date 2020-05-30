<?php

namespace App\Traits;

trait UploadTrait
{
    public function imageUpload($images, $imageColumn = null)
    {         
        $uploadedPhotos = [];

        if (is_array($images)) {
            
            // PERCORRE AS IMAGEM(NS)
            foreach ($images as $image) {
                // SALVA A(S) IMAGEM(S) NO CAMINHO APP/STORAGE/PUBLIC DENTRO DA PASTA PRODUCTS
                $uploadedPhotos[] = [$imageColumn => $image->store('products', 'public')];
            }

        } else {

            $uploadedPhotos = $images->store('logo', 'public');            
        }
        
        return $uploadedPhotos;
     
    }
}