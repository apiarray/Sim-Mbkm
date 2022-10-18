<?php

namespace App\Traits;

trait Response
{

    /**
     * Send response to controllers
     * 
     * @param bool $isOk
     * @param array|string $data
     * @param string $message
     * @return object
     */
    public function sendResponse($isOk, $data, $message): object
    {
        return (object) [
            'isOk' => $isOk,
            'message' => $message,
            'data' => $data
        ];
    }
}