<?php

namespace api\controllers;

use yii\rest\Controller;

/**
 * Site controller
 */
class SiteController extends Controller
{
    public function actionIndex()
    {
        return [
            'name' => 'Telecom Car',
            'version' => '1.0.0',
        ];
    }
}
