<?php

namespace Apps\Http;

class JsonResponse
{
    public static function success($result=null, string $id=null) :array
    {
        return [
            'jsonrpc' => '2.0',
            'result' => $result,
            'id' => $id
        ];
    }

    public static function error(string $message, int $code, string $id=null) :array
    {
        return [
            'jsonrpc' => '2.0',
            'error' => [
                'code' => $code,
                'message' => $message
            ],
            'id' => $id
        ];
    }
}