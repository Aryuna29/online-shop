<?php

namespace Service\Logger;

use Model\Logger;

class LoggerBDService implements LoggerInterface
{
    private Logger $loggerModel;
    public function __construct()
    {
        $this->loggerModel = new Logger();
    }
    public function log($exception)
    {
        $date = date('Y-m-d H:i:s');
        $message = $exception->getMessage();
        $file = $exception->getFile();
        $line = $exception->getLine();
        $this->loggerModel->logBD($message, $file, $line, $date);
        require_once '../Views/500.php';
    }
}