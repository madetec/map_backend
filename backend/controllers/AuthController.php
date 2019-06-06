<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace backend\controllers;

use uztelecom\forms\auth\SignInForm;
use uztelecom\forms\auth\SignUpForm;
use uztelecom\services\AuthService;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;

/** @property AuthService $service */
class AuthController extends Controller
{

    public $service;

    public function __construct(string $id, $module, AuthService $authService, array $config = [])
    {
        $this->service = $authService;
        parent::__construct($id, $module, $config);
    }

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'sign-out' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {

        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * @return string|\yii\web\Response
     * @throws \yii\base\InvalidArgumentException
     */
    public function actionSignIn()
    {
        if ($this->service->isFirstUser()) {
            $this->redirect(['auth/sign-up']);
        }


        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $form = new SignInForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->signIn($form);
                return $this->goBack();
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
                return $this->goBack();
            }
        }

        return $this->render('sign-in', [
            'model' => $form,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \yii\base\InvalidArgumentException
     */
    public function actionSignUp()
    {
        if (!$this->service->isFirstUser()) {
            return $this->goBack();
        }
        $form = new SignUpForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $this->service->signUp($form);
                $this->redirect(['auth/sign-in']);
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('sign-up', [
            'model' => $form
        ]);
    }

    /**
     * @return \yii\web\Response
     */
    public function actionSignOut()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
}