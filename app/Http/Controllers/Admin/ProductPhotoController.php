<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\ProductPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class ProductPhotoController extends Controller
{
    public function removePhoto(Request $request)
    {
        // RECUPERA A PHOTO
        $photoName = $request->photoName;

        // REMOVER DA PASTA
        if (Storage::disk('public')->exists($photoName)) {
            Storage::disk('public')->delete($photoName);
        }

        // REMOVER DO BANCO
        // 1 - RECUPERA A PHOTO NO CAMPO IMAGE PELO NOME DA PHOTO
        $removePhoto = ProductPhoto::where('image', $photoName);
        // 2 - RECUPERA O ID DO PRODUCT DA PHOTO
        $productId = $removePhoto->first()->product_id;
        // 3 - REMOVE
        $removePhoto->delete();

        // EXIBE UMA MENSAGEM
        flash('Imagem removida com sucesso.');
        // REDIRECIONA PARA A MESMA TELA
        return redirect()->route('admin.products.edit', ['product' => $productId]);

    }
}
