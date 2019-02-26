<?php

namespace api\controllers\user;

use uztelecom\entities\user\User;
use uztelecom\helpers\UserHelper;
use uztelecom\readModels\UserReadRepository;
use yii\helpers\ArrayHelper;
use yii\rbac\Role;
use yii\rest\Controller;

class ProfileController extends Controller
{
    public $users;

    public function __construct(
        string $id,
        $module,
        UserReadRepository $userReadRepository,
        array $config = []
    )
    {
        $this->users = $userReadRepository;
        parent::__construct($id, $module, $config);
    }

    /**
     * @SWG\Get(
     *     path="/user/roles",
     *     tags={"Profile"},
     *     description="Returns roles list",
     *     @SWG\Response(
     *         response=200,
     *         description="Success response",
     *          @SWG\Schema(@SWG\Items(ref="#/definitions/Role"))
     *     ),
     *     security={{"Bearer": {}, "OAuth2": {}}}
     * )
     */
    public function actionRoles()
    {
        return UserHelper::serializeRoles();
    }

    /**
     * @SWG\Get(
     *     path="/user/role",
     *     tags={"Profile"},
     *     description="Returns role info",
     *     @SWG\Response(
     *         response=200,
     *         description="Success response",
     *         @SWG\Schema(ref="#/definitions/Role")
     *     ),
     *     security={{"Bearer": {}, "OAuth2": {}}}
     * )
     */
    public function actionRole()
    {
        $user = $this->users->find(\Yii::$app->user->getId());
        $role = \Yii::$app->authManager->getRole($user->role);
        /** @var $role Role */
        return [
            'role' => $role->name,
            'name' => $role->description,
        ];
    }

    /**
     * @SWG\Get(
     *     path="/user/profile",
     *     tags={"Profile"},
     *     description="Returns profile info",
     *     @SWG\Response(
     *         response=200,
     *         description="Success response",
     *         @SWG\Schema(ref="#/definitions/Profile")
     *     ),
     *     security={{"Bearer": {}, "OAuth2": {}}}
     * )
     */
    public function actionIndex()
    {
        $user = $this->users->find(\Yii::$app->user->getId());
        return $this->serializeUser($user);
    }


    private function serializeUser(User $user)
    {
        return [
            'username' => $user->username,
            'name' => $user->profile->name,
            'last_name' => $user->profile->last_name,
            'father_name' => $user->profile->father_name,
            'subdivision' => $user->profile->subdivision->name,
            'position' => $user->profile->position,
            'main_phone' => $user->profile->mainPhone ? $user->profile->mainPhone->number : null,
            'main_address' => $user->profile->mainAddress ? $user->profile->mainAddress->name : null,
            'phones' => ArrayHelper::getColumn($user->profile->phones,'number'),
            'addresses' => ArrayHelper::getColumn($user->profile->addresses,'name'),
        ];
    }
}

/**
 *  @SWG\Definition(
 *     definition="Profile",
 *     type="object",
 *     required={"id"},
 *     @SWG\Property(property="username", type="string"),
 *     @SWG\Property(property="name", type="string"),
 *     @SWG\Property(property="last_name", type="string"),
 *     @SWG\Property(property="father_name", type="string"),
 *     @SWG\Property(property="subdivision", type="string"),
 *     @SWG\Property(property="position", type="string"),
 *     @SWG\Property(property="main_phone", type="integer"),
 *     @SWG\Property(property="main_address", type="string"),
 *     @SWG\Property(property="phones", type="array", @SWG\items()),
 *     @SWG\Property(property="addresses", type="array", @SWG\items())
 * )
 * @SWG\Definition(
 *     definition="Role",
 *     type="object",
 *     @SWG\Property(property="role", type="string"),
 *     @SWG\Property(property="name", type="string")
 * )
 */