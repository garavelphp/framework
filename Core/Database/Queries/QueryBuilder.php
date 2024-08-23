<?php

namespace Core\Database\Queries;

use Core\Database\Drivers\Base\BaseDatabase;


class QueryBuilder extends BaseDatabase
{

    public $table;

    public $query_string = '';

    public $database;

    public $timerStart = 0;
    public $timerEnd = 0;

    /**
     * @throws \Exception
     */
    public function __construct()
    {
        try {
            $this->timerStart = microtime(true);
            $this->database = $this->findDatabaseClass();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function result($result)
    {
        $this->timerEnd = microtime(true) - $this->timerStart;
        return $result;
    }

    public function select(string $full_query_or_columns = '*', string|null $table = null): static
    {
        if (is_null($table)) {
            $table = $this->table;
        }
        if (is_array($full_query_or_columns)) {
            $full_query_or_columns = array_map(function ($column) {
                return '"' . $column . '"';
            }, $full_query_or_columns);
            $full_query_or_columns = implode(',', $full_query_or_columns);
        }

        if ($full_query_or_columns == '*') {
            $full_query_or_columns = '*';
        }

        if (is_null($table)) {
            $this->query_string = 'SELECT ' . $full_query_or_columns;
        } else {
            $this->query_string = 'SELECT ' . $full_query_or_columns . ' FROM ' . $table;
        }
        return $this;
    }


    public function where($column, $operator, $value = null): static
    {
        if (is_null($value)) {
            $value = $operator;
            $operator = '=';
        }
        $this->query_string .= ' WHERE ' . $column . ' ' . $operator . ' ' . $value;
        return $this;
    }

    public function andWhere($column, $operator, $value = null): static
    {
        if (is_null($value)) {
            $value = $operator;
            $operator = '=';
        }
        $this->query_string .= ' AND ' . $column . ' ' . $operator . ' ' . $value;
        return $this;
    }

    public function orWhere($column, $operator, $value = null): static
    {
        if (is_null($value)) {
            $value = $operator;
            $operator = '=';
        }
        $this->query_string .= ' OR ' . $column . ' ' . $operator . ' ' . $value;
        return $this;
    }

    public function first(): mixed
    {

        return $this->result(
            $this->database->select($this,$this->query_string)->fetch()
        );
    }

    public function get(): mixed
    {
        return $this->result(
            $this->database->select($this,$this->query_string)->fetchAll()
        );
    }

    public function find($id): mixed
    {

        return $this->result(
            $this->database->select($this->query_string . ' WHERE id = ' . $id)->fetch()
        );
    }

    public function onlyThisColumns($columns = []): self
    {
        $this->query_string = str_replace('*', implode(',', $columns), $this->query_string);
        return $this;
    }

    public function insert($data): mixed
    {
        $data = array_map(function ($value) {
            return "'" . $value . "'";
        }, $data);
        $sql = 'INSERT INTO ' . $this->table . ' (';
        $sql .= implode(',', array_keys($data)) . ') VALUES (';
        $sql .= implode(',', array_values($data)) . ')
        RETURNING id';
        return $this->result(
            $this->database->select($this,$sql)->fetch()
        );
    }

    public function update($data): mixed
    {
        $sql = 'UPDATE ' . $this->table . ' SET ';
        $sql .= implode(',', array_map(function ($key, $value) {
            if (is_numeric($value)) {
                return $key . ' = ' . $value;
            }
            return $key . ' = \'' . $value.'\'';
        }, array_keys($data), array_values($data)));
        $sql .= $this->query_string;

        return $this->result(
            $this->database->select($this,$sql)->fetch()
        );
    }

    public function delete(): mixed
    {
        $sql = 'DELETE FROM ' . $this->table . $this->query_string;
        if (strlen($this->query_string) == 0) {
            return false;
        }
        return $this->result(
            $this->database->select($this,$sql)->fetch()
        );

    }

    public function getSql(): string
    {
        return $this->query_string;
    }


    public function run($query): mixed
    {
        return $this->result(
            $this->database->select($this,$query)
        );
    }





}