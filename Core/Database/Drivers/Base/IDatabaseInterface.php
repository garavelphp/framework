<?php

namespace Core\Database\Drivers\Base;

interface IDatabaseInterface
{

    public function connect();

    public function disconnect();


}