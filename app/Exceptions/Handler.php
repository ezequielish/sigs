<?php
namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable(function (Throwable $e, $request) {
            // Personalizar la respuesta de excepciones aquí
            if ($request->is('api/*')) {
                return $this->handleApiException($e, $request);
            }
        });
    }

    protected function handleApiException(Throwable $e, $request)
    {
        $code = ! empty($e->getCode()) ? $e->getCode() : 400;

        //Mesajes de error del validador de request
        if (property_exists($e, 'validator')) {
            foreach ($e->validator->errors()->all() as $key => $value) {
                return response()->json(
                    [
                        'message' => $value,
                        'error'   => true,
                    ], 400);
            }
        }
        //Mensajes de error manejados con throw Exception
        if (\property_exists($e, 'message')) {
            return response()->json(
                [
                    'message' => $e->getMessage(),
                    'error'   => true,
                ], $code);
        }

        // // 404 NOT FOUND
        if (method_exists($e, 'getStatusCode')) {

            if (intval($e->getStatusCode()) == 404) {

                return response()->json(
                    [
                        'message' => "Not Found",
                        'error'   => true,
                    ], 404);
            }
        }

        return response()->json(
            [
                'message' => "Error interno del servidor.",
                'error'   => true,
            ], 500);
    }
}
