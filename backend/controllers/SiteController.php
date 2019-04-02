<?php
namespace backend\controllers;

use common\models\LoginForm;
use uztelecom\readModels\CarReadRepository;
use uztelecom\readModels\OrderReadRepository;
use uztelecom\readModels\UserReadRepository;
use yii\filters\VerbFilter;
use yii\web\Controller;

/**
 * Site controller
 * @property $users UserReadRepository
 * @property $orders OrderReadRepository
 * @property $cars CarReadRepository
 */
class SiteController extends Controller
{
    private $users;
    private $orders;
    private $cars;

    public function __construct(
        string $id,
        $module,
        UserReadRepository $userReadRepository,
        OrderReadRepository $orderReadRepository,
        CarReadRepository $carReadRepository,
        array $config = []
    )
    {
        $this->users = $userReadRepository;
        $this->orders = $orderReadRepository;
        $this->cars = $carReadRepository;
        parent::__construct($id, $module, $config);
    }

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
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
     * @return string
     * @throws \yii\base\InvalidArgumentException
     */
    public function actionIndex()
    {
        return $this->render('index', [
            'users' => $this->users,
            'orders' => $this->orders,
            'cars' => $this->cars,
        ]);
    }

}
