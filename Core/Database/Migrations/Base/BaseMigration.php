<?php

namespace Core\Database\Migrations\Base;

use Core\Database\Queries\QueryBuilder;

class BaseMigration
{

    public function up()
    {
        return null;
    }

    public function down()
    {
        return null;
    }


    public function run($type='up')
    {

        $table = $this->$type();

        $query = $this->$type();
        if ($query && $type == 'up') {
            $query = 'CREATE TABLE ' . $table->name . ' (';
            foreach ($table->columns as $column) {
                $query .= $column->name . ' ' . $column->type . ',';
            }
            $query = rtrim($query, ',');
            $query .= ')';
            $this->runToDatabase($query);
        }elseif ($query && $type == 'down'){
            $query = $query->name;
            $query = 'DROP TABLE ' . $query;
            echo $query;
        }else{
            echo 'No query to run';
        }
    }

    public function runToDatabase($query): void
    {
        try {
            $queryBuilder = new QueryBuilder();
            $queryBuilder->run($query);
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }


    }
}