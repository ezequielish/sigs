<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CategoriaModel;

class ProductoModel extends Model
{
    use HasFactory;
    protected $table = 'productos';

    protected $fillable = [
        "categoria_id",
        "nombre",
        "descripcion",
        "stock",
        "precio",

    ];
    protected $visible = [
        "id",
        "nombre",
        "descripcion",
        "stock",
        "precio",
    ];

    public function categoria()
    {
        return $this->belongsTo(CategoriaModel::class);
    }
}
