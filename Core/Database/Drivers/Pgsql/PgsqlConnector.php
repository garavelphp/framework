<?php

namespace Core\Database\Drivers\Pgsql;

use Core\Database\Drivers\Base\IDatabaseInterface;
use Core\Database\Queries\QueryBuilder;
use Core\Exceptions\Database\TableAlreadyExistException;

class PgsqlConnector implements IDatabaseInterface
{

    public $connection;
    public $query;

    public $result;

    public $table;

    public $query_string;

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
    public function select(QueryBuilder $builder,string $sql): static|\Exception
    {
        try {
            @$this->query = pg_query($this->connection, $sql);
            $this->query_string = $sql;
            if (!$this->query) {
                throw new \Exception('Could not query Pgsql: ' . pg_last_error($this->connection));
            }
            return $this;
        }catch (\Exception $e) {
            $exceptionType = pg_last_error($this->connection);
            $tableName = $builder->table;
            if ($exceptionType == 'ERROR:  relation "'.$tableName.'" already exists') {
                throw new TableAlreadyExistException($tableName);
            }
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * @throws \Exception
     */
    public function fetch($query = null): bool|array|\Exception
    {
        if (is_null($query)) {
            $query = $this->query_string;
        }
        try {
            $result = $this->executeQuery($query);
            $this->result = pg_fetch_assoc($result);
            return $this->result;
        } catch (\Exception $e) {
            throw new \Exception('Could not fetch Pgsql');
        }
    }

    public function fetchAll($query=null)
    {
        if (is_null($query)) {
            $query = $this->query_string;
        }
        $result = $this->executeQuery($query);
        $result =pg_fetch_all($result);
        return $result;

    }


    public function executeQuery(string $query)
    {
        // Bağlantıyı kontrol et
        if (!$this->connection) {
            throw new \Exception('No connection to Pgsql');
        }

        // Sorguyu çalıştır
        $result = pg_query($this->connection, $query);
        if (!$result) {
            throw new \Exception('Query execution failed: ' . pg_last_error($this->connection));
        }

        return $result;
    }

    public function setTable(string $table): static
    {
        $this->table = $table;
        return $this;
    }



}