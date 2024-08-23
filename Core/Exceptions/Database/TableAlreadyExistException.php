<?php

namespace Core\Exceptions\Database;

use Exception;

class TableAlreadyExistException extends Exception
{
    public function __construct($tableName, $code = 0, Exception $previous = null)
    {
        $message = "The table '{$tableName}' already exists in the database.";

        parent::__construct($message, $code, $previous);
    }

    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}
