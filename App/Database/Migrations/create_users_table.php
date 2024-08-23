<?php

namespace App\Database\Migrations;


use Core\Database\Helpers\Column;
use Core\Database\Helpers\Table;
use Core\Database\Migrations\Base\BaseMigration;

class create_users_table extends BaseMigration
{


    public function up()
    {
        return Table::name('users')
            ->addColumn(Column::name('id')->integer()->primary()->autoIncrement())
            ->addColumn(Column::name('name')->string())
            ->addColumn(Column::name('email')->string())
            ->addColumn(Column::name('password')->string())
            ->addColumn(Column::name('created_at')->timestamp())
            ->addColumn(Column::name('updated_at')->timestamp());

    }

    public function down()
    {

        return Table::name('users')
            ->removeColumn(Column::name('id')->integer()->primary()->autoIncrement())
            ->removeColumn(Column::name('name')->string())
            ->removeColumn(Column::name('email')->string())
            ->removeColumn(Column::name('password')->string())
            ->removeColumn(Column::name('created_at')->timestamp())
            ->removeColumn(Column::name('updated_at')->timestamp())
            ->dropTable();
    }
}