<?php

namespace Service\Logger;

class LoggerService implements LoggerInterface
{
    public function log($exception)
    {
        $date = date('Y-m-d H:i:s');
        $messege =
        "Message: {$exception->getMessage()}
         File: {$exception->getFile()}
         Line: {$exception->getLine()}
         Data: {$date}
         ";
        error_log($messege,3, "../Storage/Log/errors.txt");
        require_once '../Views/500.php';
    }
}