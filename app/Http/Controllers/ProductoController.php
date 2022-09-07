<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Producto;
use App\Models\ProductoPrice;
use App\Models\ProductoImage;
use App\Http\Traits\ResponseApi;
use App\Models\PublicacionProducto;

class ProductoController extends Controller
{
    use ResponseApi;
    public function create(Request $request)
    {
        try {
            $prod_data = json_decode($request->data);
            //return $prod_data;
            $producto = Producto::create([
                'name' => $prod_data->name,
                'colors' => $prod_data->colors,
                'sizes' => $prod_data->sizes,
                'description' => $prod_data->description,
                'CATEGORY_PRODUCTS_id' => $prod_data->CATEGORY_PRODUCTS_id
            ]);
            $coun = 1;
            $files = $request->file("files");
            foreach ($files as $f) {
                $namefile = time() . '-' . $f->getClientOriginalName();
                $path = $f->storeAs('images', $namefile);
                ProductoImage::create([
                    'PRODUCTS_id' => $producto->id,
                    'url' => 'storage/' . $path,
                    'order' => $coun
                ]);
                $coun++;
            }
            $price = ProductoPrice::create([
                'amount' => $prod_data->amount,
                'productos_id' => $producto->id
            ]);
            return $this->successResponseWithData($producto);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function update($id, Request $request)
    {
        try {
            $prod_data = json_decode($request->data);
            $files = $request->file("files");
            $producto = Producto::where('id', $id)
                ->update([
                    'name' => $prod_data->name,
                    'colors' => $prod_data->colors,
                    'sizes' => $prod_data->sizes,
                    'description' => $prod_data->description,
                    'CATEGORY_PRODUCTS_id' => $prod_data->CATEGORY_PRODUCTS_id
                ]);

            if ($files) {
                $coun = 1;
                foreach ($files as $f) {
                    $namefile = time() . '-' . $f->getClientOriginalName();
                    $path = $f->storeAs('images', $namefile);
                    ProductoImage::create([
                        'PRODUCTS_id' => $id,
                        'url' => 'storage/' . $path,
                        'order' => $coun
                    ]);
                    $coun++;
                }
            }
            $prices = ProductoPrice::where('amount', '=', $request->amount)->where('productos_id', '=', $id);
            if (($prices->count()) == 0) {
                $precios = ProductoPrice::where('productos_id', '=', $id);
                $precios->delete();
                ProductoPrice::create([
                    'amount' => $prod_data->amount,
                    'productos_id' => $id
                ]);
            }
            return $this->successResponseWithData($producto);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function destroy($id, Request $request)
    {
        try {
            $producto = Producto::findOrFail($id);
            $producto->delete();
            return $this->successResponse();
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function restore($id, Request $request)
    {
        try {
            $producto = Producto::onlyTrashed()->find($id);
            $producto->restore();
            return $this->successResponseWithData($producto);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function forceDelete($id, Request $request)
    {
        try {
            $producto = Producto::onlyTrashed()->find($id);
            $producto->forceDelete();
            return $this->successResponse();
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function getAll(Request $request)
    {
        try {
            $productos = Producto::all();
            foreach ($productos as $p) {
                $p->categoria;
                $p->precios;
                $p->imagenes;
            }
            // throw new \Exception('probando error');
            return $this->successResponseWithData($productos);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function getByCategory($category_id)
    {
        try {
            $productos = Producto::where('CATEGORY_PRODUCTS_id', $category_id);
            foreach ($productos as $p) {
                $p->categoria;
                $p->precios;
                $p->imagenes;
            }
            // throw new \Exception('probando error');
            return $this->successResponseWithData($productos);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function getAllNotInPublication(Request $request)
    {
        try {
            $publicaciones = PublicacionProducto::pluck('PRODUCTS_id')->all();
            $productos = Producto::whereNotIn('id', $publicaciones)->get();
            foreach ($productos as $p) {
                $p->categoria;
                $p->precios;
                $p->imagenes;
            }
            // throw new \Exception('probando error');
            return $this->successResponseWithData($productos);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
    public function getAllInPublication(Request $request)
    {
        try {
            $publicaciones = PublicacionProducto::pluck('PRODUCTS_id')->all();
            $productos = Producto::whereIn('id', $publicaciones)->get();
            foreach ($productos as $p) {
                $p->categoria;
                $p->precios;
                $p->imagenes;
            }
            // throw new \Exception('probando error');
            return $this->successResponseWithData($productos);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function getAllDeletes(Request $request)
    {
        try {

            $productos = Producto::onlyTrashed()->get();
            return $this->successResponseWithData($productos);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function getOne($id, Request $request)
    {
        try {
            $producto = Producto::findOrFail($id);
            return $this->successResponseWithData($producto);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
