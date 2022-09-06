<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ProductoImage;

class ImagenController extends Controller
{
    //

    public function create(Request $request){
        $imagen=ProductoImage::create($request->all());
        return response()->json($imagen);
    }
    
    public function update($id,Request $request){
        $imagen=ProductoImage::findOrFail($id);
        $imagen->name=$request->name;
        $imagen->save();
        return $imagen;
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
