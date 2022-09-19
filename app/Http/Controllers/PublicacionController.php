<?php

namespace App\Http\Controllers;

use App\Models\CategoriaProducto;
use Illuminate\Http\Request;
use App\Models\PublicacionProducto;

class PublicacionController extends Controller
{
    //

    public function create(Request $request)
    {
        try {
            $publicacion = PublicacionProducto::create($request->all());
            return response()->json([
                "success" => true,
                "msg" => "Publicación guardada",
                "data" => $publicacion
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "msg" => "Ocurrió un error",
                "data" => $e
            ]);
        }
    }


    public function getByCategory(int $CATEGORY_PRODUCTS_id, Request $request)
    {
        $publicaciones = PublicacionProducto::where('CATEGORY_PRODUCTS_id', $CATEGORY_PRODUCTS_id)->get();
        foreach ($publicaciones as $p) {
            $p->categoria;
            $p->producto->categoria;
            $p->producto->precios;
            $p->producto->imagenes;
            $p->producto->colores;
            // $p->user;
        }

        return response()->json([
            "success" => true,
            "msg" => 'Lista de publicaciones',
            "data" => $publicaciones
        ]);
    }

    public function getCategoriesInPublication()
    {
        try {
            $ids_categoria = PublicacionProducto::select('CATEGORY_PRODUCTS_id')->get();
            $ids = [];
            foreach ($ids_categoria as $item) {
                $ids[] = $item->CATEGORY_PRODUCTS_id;
            }
            $categorias = CategoriaProducto::whereIn('id', array_unique($ids))->get();
            foreach ($categorias as $cat) {
                $cat->categoria;
            }
            return response()->json([
                "success" => true,
                "data" => $categorias
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "data" => $e
            ]);
        }
    }

    public function update($id, Request $request)
    {
        try {
            $publicacion = PublicacionProducto::findOrFail($id);
            $publicacion->name = $request->name;
            $publicacion->save();
            return response()->json([
                "success" => true,
                "msg" => "Publicación actualizada",
                "data" => $publicacion
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "msg" => "Ocurrió un error",
                "data" => $e
            ]);
        }
    }

    public function destroy($id, Request $request)
    {
        try {
            $publicacion = PublicacionProducto::findOrFail($id);
            $publicacion->delete();
            return response()->json([
                "success" => true,
                "msg" => "La publicación fue eliminada",
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "msg" => "Ocurrió un error",
                "data" => $e
            ]);
        }
    }

    public function restore($id, Request $request)
    {
        try {
            $publicacion = PublicacionProducto::onlyTrashed()->find($id);
            $publicacion->restore();
            return response()->json([
                "success" => true,
                "msg" => "La publicación fue eliminada",
                "data" => $publicacion
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "msg" => "Ocurrió un error",
                "data" => $e
            ]);
        }
    }

    public function forceDelete($id, Request $request)
    {
        try {
            $publicacion = PublicacionProducto::onlyTrashed()->find($id);
            $publicacion->forceDelete();
            return response()->json([
                "success" => true,
                "msg" => "La publicación fue restaurada",
                "data" => $publicacion
            ]);
        } catch (\Exception $e) {
            return response()->json([
                "success" => false,
                "msg" => "Ocurrió un error",
                "data" => $e
            ]);
        }
    }

    public function getAll(Request $request)
    {
        // $publicaciones = Producto::with('published_products')->get();
        // $publicaciones = PublicacionProducto::pluck('PRODUCTS_id')->all();
        // $productos = Producto::whereIn('id', $publicaciones)->get();
        $publicaciones = PublicacionProducto::all();

        foreach ($publicaciones as $p) {
            $p->categoria;
            $p->producto->categoria;
            $p->producto->precios;
            $p->producto->imagenes;
            $p->producto->colores;
            $p->user;
        }

        return response()->json([
            "success" => true,
            "msg" => 'Lista de publicaciones',
            "data" => $publicaciones
        ]);
    }

    public function getAllDeletes(Request $request)
    {
        $publicaciones = PublicacionProducto::onlyTrashed()->get();
        return response()->json([
            "success" => true,
            "msg" => "Lista de publicaciones eliminadas",
            "data" => $publicaciones
        ]);
    }

    public function getOne($id, Request $request)
    {
        $publicacion = PublicacionProducto::findOrFail($id);
        return response()->json([
            "success" => true,
            "msg" => "Publicación obtenida",
            "data" => $publicacion
        ]);
    }
}
