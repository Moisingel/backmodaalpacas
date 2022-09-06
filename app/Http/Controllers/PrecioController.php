<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ProductoPrice;

class PrecioController extends Controller
{
    //

    public function create(Request $request){
        $precio=ProductoPrice::create($request->all());
        return response()->json($precio);
    }
    
    public function update($id,Request $request){
        $precio=ProductoPrice::findOrFail($id);
        $precio->name=$request->name;
        $precio->save();
        return $precio;
    }
    
    public function destroy($id,Request $request){
        $precio = ProductoPrice::findOrFail($id);
        $precio->delete();
        return $precio;
    }
    
    public function restore($id,Request $request){
        $precio = ProductoPrice::onlyTrashed()->find($id);
        $precio->restore();
        return $precio;
    }
    
    public function forceDelete($id,Request $request){
        $precio = ProductoPrice::onlyTrashed()->find($id);
        $precio->forceDelete();
        return $precio;
    }
    
    public function getAll(Request $request){
        return ProductoPrice::all();
    }
    
    public function getAllDeletes(Request $request){
        return ProductoPrice::onlyTrashed()->get();
    }
    
    public function getOne($id,Request $request){
        return ProductoPrice::findOrFail($id);
    }
}
