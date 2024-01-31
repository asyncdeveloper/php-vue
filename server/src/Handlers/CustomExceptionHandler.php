<?php

namespace App\Handlers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Pecee\Http\Request;
use Pecee\SimpleRouter\Handlers\IExceptionHandler;

class CustomExceptionHandler implements IExceptionHandler
{

    /**
     * @param Request $request
     * @param \Exception $error
     */
    public function handleError(Request $request, \Exception $error): void
    {
        if ($error instanceof ModelNotFoundException) {
            response()->httpCode(404)->json(['message' => $error->getMessage()]);
        }

        if ($request->getUrl()->contains('/api')) {
            response()->json([
                'error' => $error->getMessage(),
                'code' => $error->getCode(),
            ]);
        }
        response()->httpCode($error->getCode() ?? 500)->json(['message' => $error->getMessage()]);
    }
}
