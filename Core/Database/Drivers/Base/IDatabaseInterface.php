<?php

namespace Core\Database\Drivers\Base;

interface IDatabaseInterface
{
    public function getConnectionConfigs();

    public function connect();

    public function disconnect();

    public function query($sql);


}