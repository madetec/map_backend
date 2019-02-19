<?php

namespace backend\controllers;

use backend\forms\UserSearch;
use uztelecom\forms\user\UserForm;
use uztelecom\readModels\UserReadRepository;
use uztelecom\services\UserManageService;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * UserController implements the CRUD actions for User model.
 * @property UserManageService $service
 * @property UserReadRepository $users
 */
class UserController extends Controller
{

    public $service;
    public $users;

    public function __construct(
        string $id, $module,
        UserManageService $userManageService,
        UserReadRepository $readRepository,
        array $config = [])
    {
        parent::__construct($id, $module, $config);

        $this->service = $userManageService;
        $this->users = $readRepository;

    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * @return string
     * @throws \yii\base\InvalidArgumentException
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws \yii\base\InvalidArgumentException
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->users->find($id),
        ]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \yii\base\InvalidArgumentException
     */
    public function actionCreate()
    {
        $form = new UserForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $user = $this->service->create($form);
                Yii::$app->session->setFlash('success', 'Пользователь успешно создан.');
                return $this->redirect(['view', 'id' => $user->id]);
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $form,
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws \yii\base\InvalidArgumentException
     */
    public function actionUpdate($id)
    {
        $user = $this->users->find($id);
        $form = new UserForm($user);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try{
                $this->service->edit($user, $form);
                Yii::$app->session->setFlash('success', 'Пользователь успешно обновлен.');
            }catch (\Exception $e){
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
            return $this->redirect(['view', 'id' => $user->id]);
        }
        return $this->render('update', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws \Throwable
     */
    public function actionDelete($id)
    {
        try{
            $this->service->remove($id);
            Yii::$app->session->setFlash('success','Пользователь успешно удален.');
        }catch (\Exception $e){
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['index']);
    }

    /**
     * @param $id
     * @param $phone_id
     * @return \yii\web\Response
     * @throws \LogicException
     * @throws \uztelecom\exceptions\NotFoundException
     */
    public function actionDeletePhone($id, $phone_id)
    {
        try {
            $this->service->removePhone($id, $phone_id);
        } catch (\DomainException $e) {
            Yii::$app->session->setFlash('error', $e->getMessage());
        }
        return $this->redirect(['view', 'id' => $id]);
    }

    /**
     * @param $id
     * @param $phone_id
     * @return \yii\web\Response
     * @throws \DomainException
     * @throws \LogicException
     * @throws \uztelecom\exceptions\NotFoundException
     */
    public function actionMovePhoneUp($id, $phone_id)
    {
        $this->service->movePhoneUp($id, $phone_id);
        return $this->redirect(['view', 'id' => $id]);
    }

    /**
     * @param $id
     * @param $phone_id
     * @return \yii\web\Response
     * @throws \DomainException
     * @throws \LogicException
     * @throws \uztelecom\exceptions\NotFoundException
     */
    public function actionMovePhoneDown($id, $phone_id)
    {
        $this->service->movePhoneDown($id, $phone_id);
        return $this->redirect(['view', 'id' => $id]);
    }

}
