<?php

namespace App\Controllers;

use App\Models\Subscriber;
use Pecee\Http\Response;
use Rakit\Validation\Validator;

class SubscriberController
{

    public function index(): Response
    {
        $page = url()->getParam('page') ?? 1;
        $limit = url()->getParam('limit') ?? 5;

        $subscribers = Subscriber::paginate(
            $limit, // per page
            ['*'], // columns to select from table (default *, means all fields)
            'page', // page name that holds the page number in the query string
            $page // current page, default 1
        );

        return response()->json($subscribers);
    }
}
