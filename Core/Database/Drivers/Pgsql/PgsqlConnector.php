<?php

namespace Core\Database\Drivers\Pgsql;

class PgsqlConnector
{

    public $connection;
    public $query;

    public $result;

    /**
     * @throws \Exception
     */
    public function __construct()
    {
        $this->connect();
    }

    public function connect(): PgsqlConnector
    {

        if (isset($this->connection)) {
            return $this;
        }
        $configs = config('database.pgsql');
        $string = 'host=' . $configs['host'] . ' port=' . $configs['port'] . ' dbname=' . $configs['database'] . ' user=' . $configs['username'] . ' password=' . $configs['password'];
        $this->connection = pg_connect($string);
        if (!$this->connection) {
            throw new \Exception('Could not connect to Pgsql');
        }
        return $this;
    }

    public function disconnect(): bool
    {
        try {
            pg_close($this->connection);
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }

    /**
     * @throws \Exception
     */
    public function select($sql)
    {
        try {
            $this->query = pg_query($this->connection, $sql);
            if (!$this->query) {
                throw new \Exception('Could not query Pgsql: ' . pg_last_error($this->connection));
            }
            return $this;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function fetch($query = null): bool|array
    {
        if (is_null($query)) {
            $query = $this->query;
        }
        try {
            $this->result = pg_fetch_assoc($query);
            return $this->result;
        } catch (\Exception $e) {
            throw new \Exception('Could not fetch Pgsql');
        }
    }


}