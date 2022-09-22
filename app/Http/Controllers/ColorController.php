<?php

namespace App\Http\Controllers;

use App\Http\Traits\ResponseApi;
use App\Models\productoColor;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    use ResponseApi;

    public function destroy($id,Request $request){

        try {
            $color = ProductoColor::findOrFail($id);
            if ($color) {
                $color->delete();
                return $this->successResponseWithData($color);
            } else {
                return $this->errorResponse('No se encontró el color');
            }
        } catch(\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function store(Request $request){
        try{
            $file = $request->file('file');
            if ($file) {
                $nameFile = time() . '-' . $file->getClientOriginalName();
                $path = $file->storeAs('images', $nameFile);
                $path = 'storage/' . $path;
            }
            $color = ProductoColor::create([
                'name' => $request->name ,
                'urlImg' => $path ?? '',
                'PRODUCTS_id' => $request->PRODUCTS_id ?? null,
            ]);
            return $this->successResponseWithData($color);
        } catch(\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
    public function uploadImage($id,Request $request){
        try{
            $file = $request->file('file');
            $productColor = ProductoColor::findOrFail($id);
            if ($file) {
                $nameFile = time() . '-' . $file->getClientOriginalName();
                $path = $file->storeAs('images', $nameFile);
                $path = 'storage/' . $path;
                $productColor->update(['urlImg' => $path]);
            }
            return $this->successResponseWithData($productColor);
        } catch(\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
    public function update($id,Request $request){
        try {
            $color = ProductoColor::findOrFail($id);
            if ($color) {
                $color->name=$request->name ?? $color->name;
                $color->save();
                return $this->successResponseWithData($color);
            }else{
                return $this->errorResponse('No se encontró el color');
            }
        } catch(\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}

