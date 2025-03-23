<?php
namespace App\Http\Controllers;

use App\Http\Requests\ProductoRequest;
use App\Models\ProductoModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    private static function filtros(Builder $query, Request $request): Builder
    {

        if ($request->has('nombre')) {
            $nombre = $request->input('nombre');
            $query->where('nombre', 'ILIKE', '%' . $nombre . '%');
        }

        if ($request->has('categoria_id') && is_numeric($request->input('categoria_id'))) {
            $categoriaId = $request->input('categoria_id');
            $query->where('categoria_id', $categoriaId);
        }

        if ($request->has('precio_min') && is_numeric($request->input('precio_min'))) {
            $precioMin = $request->input('precio_min');
            $query->where('precio', '>=', $precioMin);
        }

        if ($request->has('precio_max') && is_numeric($request->input('precio_max'))) {
            $precioMax = $request->input('precio_max');
            $query->where('precio', '<=', $precioMax);
        }

        return $query;
    }

    public function index(Request $request): JsonResponse
    {
        try {
            $productos = self::filtros(ProductoModel::query(), $request)->with('categoria')->get();
            $productos = $productos->map(function ($producto) {
                return [
                     ...$producto->toArray(),
                    'categoria' => $producto->categoria,
                ];
            });

            return response()->json([
                'error' => false,
                'data'  => $productos,
            ], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function show($id): JsonResponse
    {
        try {
            parent::validarId($id);
            $producto = ProductoModel::with('categoria')->find($id);
            if ($producto) {
                $producto = [
                     ...(array) $producto->toArray(),
                    'categoria' => $producto->categoria,
                ];
            }
            $code = $producto ? 200 : 404;
            return response()->json([
                'error' => false,
                'data'  => $producto ?? [],
            ], $code);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function store(ProductoRequest $request): JsonResponse
    {
        try {
            $data    = $request->validated();
            $created = ProductoModel::create($data);
            if (! $created) {
                throw new Exception("Error registrando el producto", 400);
            }

            return response()->json([
                'error'   => false,
                'mensaje' => "El producto se ha creado correctamente!.",
            ], 201);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update(ProductoRequest $request, $id): JsonResponse
    {
        try {
            parent::validarId($id);
            $data     = $request->validated();
            $producto = ProductoModel::find($id);

            if (! $producto) {
                throw new \Exception("El producto es inválido.", 404);
            }

            $producto->update($data);
            return response()->json([
                'error'   => false,
                'mensaje' => "El producto se ha actualizado correctamente!.",
            ], 200);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            parent::validarId($id);
            $eliminado = ProductoModel::destroy($id);
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
