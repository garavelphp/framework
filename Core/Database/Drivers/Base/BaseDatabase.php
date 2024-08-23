<?php

namespace Core\Database\Drivers\Base;

/**
 * Class BaseDatabase
 * @package Core\Database\Drivers\Base
 * @throws \Exception
 * @return BaseDatabase|callable
 * @throws \ReflectionException
 * @method static connect()
 * @method static disconnect()
 * @method static query($sql)
 * @method static findDatabaseClass()
 * @method static dbConnected()
 * @method static dbDisconnected()
 * @method static getConnectionConfigs()
 * @method static select(string $full_query_or_columns = '*', string|null $table = null)
 */
class BaseDatabase implements IDatabaseInterface
{



    public function getConnectionConfigs()
    {
        return config('database');
    }

    /**
     * @throws \Exception
     */
    public function connect()
    {
        $class = $this->findDatabaseClass();
        return $class->connect();
    }

    /**
     * @throws \Exception
     */
    public function disconnect()
    {
        $class = $this->findDatabaseClass();
        return $class->disconnect();
    }

    /**
     * @throws \Exception
     */
    public function query($sql)
    {
        $class = $this->findDatabaseClass();
        return $class->query($sql);
    }

    /**
     * @throws \Exception
     * @return IDatabaseInterface|callable
     */
    public function findDatabaseClass(): IDatabaseInterface|callable
    {
        try {
            $driver = $this->getConnectionConfigs()['driver'];
            $driver = ucfirst($driver);
            $class = 'Core\\Database\\Drivers\\' . $driver . '\\' . $driver . 'Connector';
            if (!class_exists($class)) {
                throw new \ReflectionException('Class does not exist');
            }
            if (!method_exists($class, 'connect') || !method_exists($class, 'disconnect') || !method_exists($class, 'select')) {
                throw new \ReflectionException('Class does not have required methods');
            }
            if (!is_callable($class, '__construct')) {
                throw new \ReflectionException('Class is not instantiable');
            }
            //set db is connected to global variable on the all project
            $this->dbConnected();
            return new $class();
        } catch (\Throwable $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function dbConnected()
    {
        $GLOBALS['dbIsConnected'] = true;
    }

    public function dbDisconnected()
    {
        $GLOBALS['dbIsConnected'] = false;
    }
}