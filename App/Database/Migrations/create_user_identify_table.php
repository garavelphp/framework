<?php

namespace App\Database\Migrations;


use Core\Database\Helpers\Column;
use Core\Database\Helpers\Table;
use Core\Database\Migrations\Base\BaseMigration;

class create_user_identify_table extends BaseMigration
{


    public function up()
    {
        return Table::name('user_identifies')
            ->addColumn(Column::name('id')->integer()->primary()->autoIncrement())
            ->addColumn(Column::name('user_id')->integer())
            ->addColumn(Column::name('passport_number')->string())
            ->addColumn(Column::name('created_at')->timestamp())
            ->addColumn(Column::name('updated_at')->timestamp());

    }

    public function down()
    {

        return Table::name('user_identifies')
            ->removeColumn(Column::name('id')->integer()->primary()->autoIncrement())
            ->removeColumn(Column::name('user_id')->integer())
            ->removeColumn(Column::name('passport_number')->string())
            ->removeColumn(Column::name('created_at')->timestamp())
            ->removeColumn(Column::name('updated_at')->timestamp())
            ->dropTable();
    }
}