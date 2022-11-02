<?php
/**
 * Created by PhpStorm.
 * User: note
 * Date: 06.06.2021
 * Time: 15:57
 */

namespace App\Services\Response;


class ResponseService
{
    public static function sendJsonReponse ($status, $data = [], $code = 200, $errors = []) {
        return response()->json([
            'status' => $status,
            'data' => $data,
            'errors' => $errors,
        ], $code);
    }
}