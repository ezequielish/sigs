<?php
namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public static function validarId($id)
    {
        if ($id && ! is_numeric($id)) {
            throw new \Exception("El id es inválido.", 400);
        }
    }
}
