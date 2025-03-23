<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(Request $request): array
    {
        $rules = [
            'nombre'       => [
                'string',
                'max:30',
            ],
            'descripcion'  => [
                'string',
                'max:50',
            ],
            'stock'        => [
                'numeric',
            ],
            'precio'       => [
                'numeric',
                'decimal:2',
            ],
            'categoria_id' => [
                'numeric',
                'exists:categorias,id',
            ],
        ];

        if ($request->method() == "POST") {
            array_unshift($rules['nombre'], 'required');
            array_unshift($rules['nombre'], Rule::unique('productos', 'nombre'));
            array_unshift($rules['stock'], 'required');
            array_unshift($rules['precio'], 'required');
            array_unshift($rules['categoria_id'], 'required');
            return $rules;
        }

        if ($request->method() == "PUT") {
            $id = $this->route('id');
            array_unshift($rules['nombre'], Rule::unique('productos', 'nombre')->ignore($id, 'id'));

            return $rules;
        }

    }

    public function messages(): array
    {
        return [
            'nombre.required'       => 'El nombre es obligatorio.',
            'nombre.string'         => 'El nombre debe ser una cadena de texto.',
            'nombre.max'            => 'El nombre no debe exceder los :max caracteres.',
            'descripcion.string'    => 'La descripción debe ser una cadena de texto.',
            'descripcion.max'       => 'La descripción no debe exceder los :max caracteres.',
            'stock.required'        => 'El stock es obligatorio.',
            'stock.numeric'         => 'El stock debe ser un valor entero.',
            'precio.numeric'        => 'El precio debe tener 2 decimales ej: 14.00.',
            'precio.decimal'        => 'El del precio debe tener 2 decimales ej: 14.00',
            'categoria_id.required' => 'El ID de la categoria es obligatorio.',
            'categoria_id.numeric'  => 'El IDde la categoria debe ser un valor numérico.',
            'categoria_id.exists'   => 'El ID de la categoria no existe en la base de datos.',
        ];
    }
}
