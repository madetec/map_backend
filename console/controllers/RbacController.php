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
     * @throws \yii\base\Exception
     */
    public function actionInit()
    {
        /** @var AuthManager $auth */
        $auth = \Yii::$app->authManager;
        $auth->removeAll();

        $crud = $auth->createPermission('crud');
        $auth->add($crud);

        $this->stdout(PHP_EOL . 'create crud permission done!');


        $user = $auth->createRole('user');
        $user->description = 'User';
        $auth->add($user);

        $this->stdout(PHP_EOL . 'create role user done!');

        $driver = $auth->createRole('driver');
        $driver->description = 'driver';
        $auth->add($driver);

        $this->stdout(PHP_EOL . 'create role driver done!');

        $administrator = $auth->createRole('admin');
        $administrator->description = 'admin';
        $auth->add($administrator);

        $this->stdout(PHP_EOL . 'create role admin done!');

        // add children role

        $auth->addChild($administrator, $crud);

        $auth->addChild($administrator, $driver);

        $this->stdout(PHP_EOL . 'Add child admin -> driver done!');

        $auth->addChild($driver, $user);

        $this->stdout(PHP_EOL . 'Add child driver -> user done!' . PHP_EOL);


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