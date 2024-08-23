<?php

namespace Core\Exceptions\Database;

use Exception;

class TableAlreadyExistException extends Exception
{
    // Özel mesaj ve kod ile exception fırlatmak için constructor ekleyelim
    public function __construct($tableName, $code = 0, Exception $previous = null)
    {
        // Özel mesaj: tablo adını mesajda belirtmek için özelleştiriyoruz
        $message = "The table '{$tableName}' already exists in the database.";

        // Parent class'ın constructor'ını çağırıyoruz
        parent::__construct($message, $code, $previous);
    }

    // İsteğe bağlı olarak, özel loglama veya hata işleme yöntemleri ekleyebilirsin
    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}
