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


    /**
     * @throws \Exception
     */
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
            $this->runToDatabase($query,$table->name);
        }elseif ($query && $type == 'down'){
            $table = $query->name;
            $query = 'DROP TABLE ' . $table;
            $this->runToDatabase($query,$table->name);
        }else{
            echo 'No query to run';
        }
    }

    /**
     * @throws \Exception
     */
    public function runToDatabase($query,$table): void
    {
        try {
            QueryBuilder::table($table)->run($query);
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }


    }
}