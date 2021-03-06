<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace api\controllers\common;

use uztelecom\forms\user\DeviceForm;
use uztelecom\services\UserManageService;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;

/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 * Class DeviceController
 * @package api\controllers\common
 * @property UserManageService $userService;
 */
class DeviceController extends Controller
{
    public $userService;

    public function __construct(
        string $id,
        $module,
        UserManageService $userManageService,
        array $config = []
    )
    {
        $this->userService = $userManageService;
        parent::__construct($id, $module, $config);
    }

    /**
     * @SWG\Get(
     *     path="/device/remove/{uid}",
     *     tags={"Device"},
     *     description="Return boolean",
     *      @SWG\Parameter(
     *          name="uid",
     *          in="path",
     *          required=true,
     *          type="string"
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="true || false"
     *     ),
     *     security={{"Bearer": {}, "OAuth2": {}}}
     * )
     */
    /**
     * @param $uid
     * @return bool
     * @throws BadRequestHttpException
     */
    public function actionRemove($uid)
    {
        try {
            $this->userService->removeDevice($uid);
            return true;
        } catch (\Exception $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
    }

    /**
     * @SWG\Post(
     *     path="/device/add",
     *     tags={"Device"},
     *     description="Return boolean",
     *      @SWG\Parameter(
     *          name="requst body",
     *          in="body",
     *          required=true,
     *          type="object",
     *          @SWG\Schema(ref="#/definitions/DeviceForm")
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="true || false"
     *     ),
     *     security={{"Bearer": {}, "OAuth2": {}}}
     * )
     */
    /**
     * @return bool|DeviceForm
     * @throws BadRequestHttpException
     * @throws \yii\base\InvalidArgumentException
     */
    public function actionAdd()
    {
        $form = new DeviceForm();
        $form->load(\Yii::$app->request->bodyParams, '');
        if ($form->validate()) {
            try {
                $this->userService->addDevice(\Yii::$app->user->getId(), $form);
                return true;
            } catch (\Exception $e) {
                throw new BadRequestHttpException($e->getMessage());
            }
        }
        return $form;
    }
}


/**
 * @SWG\Definition(
 *     definition="DeviceForm",
 *     type="object",
 *     @SWG\Property(property="uid", type="string", enum="string -> required"),
 *     @SWG\Property(property="firebase_token", type="string", enum="string -> required"),
 *     @SWG\Property(property="name", type="string", enum="string -> optinal"),
 * )
 */
