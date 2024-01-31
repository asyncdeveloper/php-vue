<?php

namespace App\Core;

use App\Handlers\CustomExceptionHandler;
use Pecee\Http\Middleware\Exceptions\TokenMismatchException;
use Pecee\SimpleRouter\Exceptions\HttpException;
use Pecee\SimpleRouter\Exceptions\NotFoundHttpException;
use Pecee\SimpleRouter\SimpleRouter;

class Router extends SimpleRouter
{
    /**
     * @throws HttpException
     * @throws NotFoundHttpException
     * @throws TokenMismatchException
     */
    public function __construct()
    {
        SimpleRouter::group(['exceptionHandler' => CustomExceptionHandler::class], function () {
            SimpleRouter::get('/', function () {
                return response()->json(['message' => 'Welcome to PHP Rest API visit api/subscribers']);
            });

            SimpleRouter::group(['prefix' => 'api'], function () {
                SimpleRouter::resource('subscribers', 'SubscriberController');
            });
        });

        // change default namespace for all routes
        parent::setDefaultNamespace('\App\Controllers');

        // Do initial stuff
        parent::start();
    }
}
