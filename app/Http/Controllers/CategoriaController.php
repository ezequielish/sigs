<?php
namespace App\Http\Controllers;

use App\Http\Requests\CategoriaRequest;
use App\Models\CategoriaModel;
use Illuminate\Http\JsonResponse;

class CategoriaController extends Controller
{
    public function store(CategoriaRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();

            $created = CategoriaModel::create($data);
            if (! $created) {
                throw new Exception("Error registrando la categoria", 400);
            }

            return response()->json([
                'error'   => false,
                'mensaje' => "La categoria se ha creado correctamente!.",
            ], 201);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update(CategoriaRequest $request, $id): JsonResponse
    {
        try {

            if (! is_numeric($id)) {
                throw new \Exception("El id es inválido.", 400);
            }
            $data      = $request->validated();
            $categoria = CategoriaModel::find($id);

            if (! $categoria) {
                throw new \Exception("La categoria es inválida.", 404);
            }

            $categoria->update($data);
            return response()->json([
                'error'   => false,
                'mensaje' => "La categoria se ha actualizado correctamente!.",
            ], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function index(): JsonResponse
    {
        try {
            $categorias = CategoriaModel::all();
            return response()->json([
                'error' => false,
                'data'  => $categorias,
            ], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function show($id): JsonResponse
    {
        try {
            if (! is_numeric($id)) {
                throw new \Exception("El id es inválido.", 400);
            }
            $categoria = CategoriaModel::find($id);
            $code      = $categoria ? 200 : 404;
            return response()->json([
                'error' => false,
                'data'  => $categoria ?? [],
            ], $code);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            if (! is_numeric($id)) {
                throw new \Exception("El id es inválido.", 400);
            }
            $eliminado = CategoriaModel::destroy($id);
            if ($eliminado === 0) {
                throw new \Exception("Registro no encontrado.", 404);
            }

            return response()->json([
                'error' => false,
                'data'  => [],
            ], 200);
        } catch (\Throwable $th) {
            throw $th;
        }

    }

}
