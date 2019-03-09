<?php

namespace api\controllers\driver;

use uztelecom\readModels\UserReadRepository;
use uztelecom\services\UserManageService;
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
     *     path="/driver/status/active",
     *     tags={"Driver"},
     *     description="Sets active status",
     *     @SWG\Response(
     *         response=200,
     *         description="Success response",
     *     ),
     *     security={{"Bearer": {}, "OAuth2": {}}}
     * )
     * @return bool
     * @throws BadRequestHttpException
     */
    public function actionActive()
    {
        try {
            $this->service->active(\Yii::$app->user->getId());
        } catch (\Exception $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        return true;
    }

    /**
     * @SWG\Patch(
     *     path="/driver/status/busy",
     *     tags={"Driver"},
     *     description="Sets busy status",
     *     @SWG\Response(
     *         response=200,
     *         description="Success response",
     *     ),
     *     security={{"Bearer": {}, "OAuth2": {}}}
     * )
     * @return bool
     * @throws BadRequestHttpException
     */
    public function actionBusy()
    {
        try {
            $this->service->busy(\Yii::$app->user->getId());
        } catch (\Exception $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        return true;
    }

}