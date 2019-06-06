<?php

namespace backend\controllers;

use backend\forms\SubdivisionSearch;
use uztelecom\entities\Subdivision;
use uztelecom\forms\SubdivisionForm;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * SubdivisionController implements the CRUD actions for Subdivision model.
 */
class SubdivisionController extends Controller
{
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
            ]
        ];
    }

    /**
     * @return string
     * @throws \yii\base\InvalidArgumentException
     */
    public function actionIndex()
    {
        $searchModel = new SubdivisionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidArgumentException
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws \yii\base\InvalidArgumentException
     */
    public function actionCreate()
    {
        $form = new SubdivisionForm();
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            $subdivision = Subdivision::create($form);
            return $this->redirect(['view', 'id' => $subdivision->id]);
        }
        return $this->render('create', [
            'model' => $form,
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     * @throws \yii\base\InvalidArgumentException
     */
    public function actionUpdate($id)
    {
        $subdivision = $this->findModel($id);
        $form = new SubdivisionForm($subdivision);
        if ($form->load(Yii::$app->request->post()) && $form->validate()) {
            return $this->redirect(['view', 'id' => $subdivision->id]);
        }
        return $this->render('update', [
            'model' => $form,
        ]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * @param $id
     * @return Subdivision|null
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = Subdivision::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
