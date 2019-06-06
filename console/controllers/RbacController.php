<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace console\controllers;


use common\components\AuthManager;
use uztelecom\entities\user\User;
use yii\console\Controller;

class RbacController extends Controller
{
    /**
     * @throws \Exception
     */
    public function actionInit()
    {
        /** @var AuthManager $auth */
        $auth = \Yii::$app->authManager;
        $auth->removeAll();

//        $create_dispatcher = $auth->createPermission('create dispatcher');
//        $auth->add($create_dispatcher);
//
//
//        $this->stdout(PHP_EOL . 'create crud permission done!');


        $user = $auth->createRole('user');
        $user->description = 'Пользователь';
        $auth->add($user);

        $this->stdout(PHP_EOL . 'create role user done!');

        $driver = $auth->createRole('driver');
        $driver->description = 'Водитель';
        $auth->add($driver);

        $this->stdout(PHP_EOL . 'create role driver done!');

        $dispatcher = $auth->createRole('dispatcher');
        $dispatcher->description = 'Диспечер';
        $auth->add($dispatcher);

        $this->stdout(PHP_EOL . 'create role dispatcher done!');

        $administrator = $auth->createRole('administrator');
        $administrator->description = 'Администратор';
        $auth->add($administrator);

        $this->stdout(PHP_EOL . 'create role admin done!');

        $auth->addChild($administrator, $dispatcher);
        $auth->addChild($dispatcher, $user);

        $this->stdout(PHP_EOL . 'add child done!');

        $this->stdout('RBAC configure Done!' . PHP_EOL);
    }

    public function actionTest()
    {
        $request = new \yii\web\Request();

        $request->enableCookieValidation = false;
        $request->enableCsrfValidation = false;
        $request->enableCsrfCookie = false;
        try {
            \Yii::$app->set('request', $request);
        } catch (\Exception $e) {

        }

        $auth = \Yii::$app->authManager;

        $role = $auth->getRole('administrator');

        $user = User::findOne(1);

        $auth->assign($role, $user->id);

        echo PHP_EOL;

    }
}