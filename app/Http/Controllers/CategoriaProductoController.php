<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CategoriaProducto;
use App\Http\Traits\ResponseApi;

class CategoriaProductoController extends Controller
{
    use ResponseApi;

    public function create(Request $request)
    {
        try {
            $categoria = CategoriaProducto::create($request->all());
            return $this->successResponseWithData($categoria);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function update($id, Request $request)
    {
        try {
            $categoria = CategoriaProducto::findOrFail($id);
            $categoria->name = $request->name;
            $categoria->parent_category_id = $request->parent_category_id;
            $categoria->save();
            return $this->successResponseWithData($categoria);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function destroy($id, Request $request)
    {
        try {
            $categoria = CategoriaProducto::findOrFail($id);
            $categoria->delete();
            return $this->successResponse();
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function restore($id, Request $request)
    {
        try {
            $categoria = CategoriaProducto::onlyTrashed()->find($id);
            $categoria->restore();
            return $this->successResponseWithData($categoria);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function forceDelete($id, Request $request)
    {
        try {
            $categoria = CategoriaProducto::onlyTrashed()->find($id);
            $categoria->forceDelete();
            return $this->successResponseWithData($categoria);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function getAll(Request $request)
    {
        try {
            $categorias = CategoriaProducto::all();
            foreach ($categorias as $cat) {
                $cat->categoria;
                $cat->productos;
            }
            return $this->successResponseWithData($categorias);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function getAllDeletes(Request $request)
    {
        try {
            $categorias = CategoriaProducto::onlyTrashed()->get();
            return $this->successResponseWithData($categorias);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function getOne($id, Request $request)
    {
        try {
            $categoria = CategoriaProducto::findOrFail($id);
            return $this->successResponseWithData($categoria);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
