<?php

namespace api\controllers\user;

use uztelecom\entities\user\User;
use uztelecom\forms\user\AddressForm;
use uztelecom\helpers\UserHelper;
use uztelecom\readModels\UserReadRepository;
use uztelecom\services\UserManageService;
use yii\helpers\ArrayHelper;
use yii\rbac\Role;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;

class ProfileController extends Controller
{
    private $service;
    private $users;

    public function __construct(
        string $id,
        $module,
        UserReadRepository $userReadRepository,
        UserManageService $userManageService,
        array $config = []
    )
    {
        $this->users = $userReadRepository;
        $this->service = $userManageService;
        parent::__construct($id, $module, $config);
    }

    /**
     * @SWG\Patch(
     *     path="/user/profile/address",
     *     tags={"Profile"},
     *     @SWG\Parameter(name="body", in="body", required=true, type="object", @SWG\Schema(ref="#/definitions/AddressForm")),
     *     @SWG\Response(
     *         response=200,
     *         description="Success response",
     *     ),
     *     security={{"Bearer": {}, "OAuth2": {}}}
     * )
     * @return bool|AddressForm
     * @throws BadRequestHttpException
     * @throws \yii\base\InvalidArgumentException
     */
    public function actionAddAddress()
    {
        $form = new AddressForm();
        $form->load(\Yii::$app->request->bodyParams, '');
        if ($form->validate()) {
            try {
                $this->service->addAddress(\Yii::$app->user->getId(), $form);
                return true;
            } catch (\Exception $e) {
                throw new BadRequestHttpException($e->getMessage());
            }
        }
        return $form;
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
            'user_id' => $user->id,
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
            'status' => [
                'code' => $user->status,
                'text' => UserHelper::getStatusText($user->status),
            ],
            'role' => $user->role
        ];
    }
}

/**
 *  @SWG\Definition(
 *     definition="Profile",
 *     type="object",
 *     required={"id"},
 *     @SWG\Property(property="user_id", type="integer"),
 *     @SWG\Property(property="username", type="string"),
 *     @SWG\Property(property="name", type="string"),
 *     @SWG\Property(property="last_name", type="string"),
 *     @SWG\Property(property="father_name", type="string"),
 *     @SWG\Property(property="subdivision", type="string"),
 *     @SWG\Property(property="position", type="string"),
 *     @SWG\Property(property="main_phone", type="integer"),
 *     @SWG\Property(property="main_address", type="string"),
 *     @SWG\Property(property="phones", type="array", @SWG\items()),
 *     @SWG\Property(property="addresses", type="array", @SWG\items()),
 *     @SWG\Property(property="status", type="object",
 *          @SWG\Property(property="code", type="integer"),
 *          @SWG\Property(property="text", type="string")
 *     )
 * )
 *
 * @SWG\Definition(
 *     definition="Role",
 *     type="object",
 *     @SWG\Property(property="role", type="string"),
 *     @SWG\Property(property="name", type="string")
 * )
 *
 * @SWG\Definition(
 *     definition="AddressForm",
 *     type="object",
 *     @SWG\Property(property="name", type="string", enum="string -> required"),
 *     @SWG\Property(property="lat", type="number", enum="float -> optional"),
 *     @SWG\Property(property="lng", type="number", enum="float -> optional"),
 * )
 */