<?php

namespace App\Http\Controllers;

use App\Http\Traits\ResponseApi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ProductoImage;

class ImagenController extends Controller
{
    use ResponseApi;
    public function create(Request $request){
        $imagen=ProductoImage::create($request->all());
        return response()->json($imagen);
    }

    public function update($id,Request $request){
        $imagen=ProductoImage::findOrFail($id);
        if ($imagen) {
            $imagen->PRODUCTS_COLORS_id=$request->PRODUCTS_COLORS_id ?? $imagen->PRODUCTS_COLORS_id;
            return $this->successResponseWithData($imagen);
        }else{
            return response()->json(['success' => false]);
        }
    }

    public function destroy($id,Request $request){
        $imagen = ProductoImage::findOrFail($id);
        $imagen->delete();
        return $imagen;
    }

    public function restore($id,Request $request){
        $imagen = ProductoImage::onlyTrashed()->find($id);
        $imagen->restore();
        return $imagen;
    }

    public function forceDelete($id,Request $request){
        $imagen = ProductoImage::onlyTrashed()->find($id);
        $imagen->forceDelete();
        return $imagen;
    }

    public function getAll(Request $request){
        return ProductoImage::all();
    }

    public function getAllDeletes(Request $request){
        return ProductoImage::onlyTrashed()->get();
    }

    public function getOne($id,Request $request){
        return ProductoImage::findOrFail($id);
    }
}
