<?php

namespace App\Utils;

use Illuminate\Http\Response;

class RequestResponse
{
    public static function success($data = [], $message = '', $status = Response::HTTP_OK)
    {
        return response()->json(['result' => ['message' => $message, 'data' => $data]], $status);
    }

    public static function error($message = '', $errors = [], $status = Response::HTTP_BAD_REQUEST)
    {
        return response()->json(['result' => ['message' => $message, 'errors' => $errors]], $status);
    }
}
