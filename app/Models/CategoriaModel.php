<?php
namespace App\Models;

use App\Models\ProductoModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaModel extends Model
{
    use HasFactory;
    protected $table = 'categorias';

    protected $fillable = [
        "nombre",

    ];
    protected $visible = [
        "id",
        "nombre",
    ];

    public function productos()
    {
        return $this->hasMany(ProductoModel::class);
    }
}
