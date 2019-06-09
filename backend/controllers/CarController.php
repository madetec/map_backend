<?php

namespace backend\controllers;

use backend\forms\CarSearch;
use uztelecom\entities\cars\Car;
use uztelecom\forms\cars\CarForm;
use uztelecom\forms\cars\CarSearchForm;
use uztelecom\readModels\CarReadRepository;
use uztelecom\services\CarManageService;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * CarController implements the CRUD actions for Car model.
 */
class CarController extends Controller
{
    private $service;
    private $cars;

    public function __construct(
        string $id, $module,
        CarManageService $carManageService,
        CarReadRepository $carReadRepository,
        array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->service = $carManageService;
        $this->cars = $carReadRepository;
    }

    /**
     * @return string
     * @throws \yii\base\InvalidArgumentException
     */
    public function actionIndex()
    {
        $searchModel = new CarSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws \yii\base\InvalidArgumentException
     */
    public function actionUpdate($id)
    {
        $car = $this->cars->find($id);
        $form = new CarForm($car);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $car = $this->service->edit($car->id, $form);
                Yii::$app->session->setFlash('success', 'Машина успешно обновлена.');
                return $this->redirect(['view', 'id' => $car->id]);
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }

        return $this->render('update', [
            'car' => $car,
            'form' => $form,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \yii\base\InvalidArgumentException
     */
    public function actionCreate()
    {
        $form = new CarForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            try {
                $car = $this->service->create($form);
                Yii::$app->session->setFlash('success', 'Машина успешно создана.');
                return $this->redirect(['view', 'id' => $car->id]);
            } catch (\Exception $e) {
                Yii::$app->session->setFlash('error', $e->getMessage());
            }
        }
        return $this->render('create', [
            'model' => $form,
        ]);
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
     * Displays a single Car model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    /**
     * Deletes an existing Car model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Car model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Car the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Car::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
