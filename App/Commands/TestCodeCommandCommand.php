<?php

namespace App\Commands;

use App\Models\UserIdentifyModel;
use App\Models\UserModel;
use GaravelPHP\Commands\Base\BaseCommand;

class TestCodeCommandCommand extends BaseCommand
{

    /**
     * Your command signature
     * @var string Command signature
     */
    public $signature = 'test-code';

    /**
     * Your command description
     * @var string Command description
     */
    public $description = 'Your command description';

    /**
     * Your command handler
     * @return void
     */
    public function run()
    {


        /**
         * @var UserModel $user
         */
        $user = (new UserModel())->find(13);
        /**
         * @var UserIdentifyModel $identifyOne
         */
        $identifyOne = $user->getIdentifyOne();
        /**
         * @var UserIdentifyModel $identifyMany
         */
        $identifyMany = $user->getIdentifyMany();

    }

    public function query()
    {
        $model = new UserModel();
        $model = $model->where('id', '<', 13);
        return $model->first();

    }


    public function insert()
    {
        $model = new UserModel();
        $model->name = 'John Doe';
        $model->email = 'test@mail.com';
        $model->password = 'password';
        $userId = $model->save();
        $identify = new UserIdentifyModel();
        $identify->user_id = $userId->id;
        $identify->passport_number = '123456789';
        $identify = $identify->save();
        return $userId->getIdentify();
    }

    public function find($id)
    {
        $model = new UserModel();
        $model = $model->find($id);
        return $model;
    }

    public function update()
    {
        $model = new UserModel();
        $model = $model->find(1);
        $model->name = 'Jane Doe';
        $model->save();
    }


    public function delete($id)
    {
        $model = new UserModel();
        $model = $model->where('id', $id);
        $model->delete();
    }

}

