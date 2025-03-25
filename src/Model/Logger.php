<?php

namespace Model;

class Logger extends Model
{
    private string $message;
    private string $file;
    private int $line;
    private string $date;

    protected static function getTableName(): string
    {
        return 'loggers';
    }

    public function logBD(string $message, string $file, int $line, string $date)
    {
        $tableName = static::getTableName();
        $stmt = static::getPDO()->prepare("
            INSERT INTO {$tableName} (message, file, line, date) 
            VALUES (:message, :file, :line, :date)
            ");
        $stmt->execute(['message' => $message, 'file' => $file, 'line' => $line, 'date' => $date]);
    }
}