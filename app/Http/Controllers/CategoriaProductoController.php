<?php

namespace App\Http\Controllers;

use App\Http\Traits\ResponseApi;
use App\Models\CategoriaProducto;
use Illuminate\Http\Request;

class CategoriaProductoController extends Controller
{
    use ResponseApi;


    public function create(Request $request)
    {
        try {
            $data = json_decode($request->data);
            $files = $request->file("file")[0];

            if ($files) {
                // concat date expression until microseconds and extension original
                $nameFile = date('YmdHisu') . '.' . $files->getClientOriginalExtension();
                $path = $files->storeAs('images', $nameFile);
                $path = 'storage/' . $path;
            }

            //return $this->successResponseWithData(['a' => $prod_data, 'DATA' => $data, 'FILE' => $files, 'request' => $request]);
            $categoria = CategoriaProducto::create(
                [
                    'name' => $data->name,
                    'parent_category_id' => $data->parent_category_id,
                    'urlImg' => $path ?? ''
                ]
            );
            return $this->successResponseWithData($categoria);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function update($id, Request $request)
    {
        try {
            if ($request->file("file")) {
                $files = $request->file("file")[0];
                $nameFile = date('u') . '.' . $files->getClientOriginalExtension();
                $path = $files->store('images');
                $path = 'storage/' . $path;
            } else {
                $path = null;
            }
            $data = json_decode($request->data);

            if ($path) {
                $updateData = [
                    'name' => $data->name,
                    'parent_category_id' => $data->parent_category_id,
                    'urlImg' => $path
                ];
            } else {
                $updateData = [
                    'name' => $data->name,
                    'parent_category_id' => $data->parent_category_id
                ];
            }

            $categoria = CategoriaProducto::where('id', $id)->update($updateData);

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
            $categorias = CategoriaProducto::with('categorias', 'productos')->get();
            return $this->successResponseWithData($categorias);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function getAllWithChildrens(Request $request)
    {
        try {
            $categorias = CategoriaProducto::with('categorias')->get();
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
