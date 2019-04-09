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