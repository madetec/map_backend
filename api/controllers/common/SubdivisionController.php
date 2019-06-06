<?php


namespace api\controllers\common;


use uztelecom\entities\Subdivision;
use yii\rest\Controller;

class SubdivisionController extends Controller
{
    /**
     * @SWG\Get(
     *     path="/subdivisions",
     *     tags={"Subdivision"},
     *     description="Returns subdivisions list",
     *     @SWG\Response(
     *         response=200,
     *         description="Success response",
     *         @SWG\Schema(@SWG\Items(ref="#/definitions/Subdivision"))
     *     ),
     *     security={{"Bearer": {}, "OAuth2": {}}}
     * )
     */
    public function actionIndex()
    {
        return Subdivision::find()->all();
    }
}

/**
 * @SWG\Definition(
 *     definition="Subdivision",
 *     type="object",
 *       @SWG\Property(property="id", type="integer"),
 *       @SWG\Property(property="name", type="string"),
 *       @SWG\Property(property="lat", type="number"),
 *       @SWG\Property(property="lng", type="number"),
 *       @SWG\Property(property="address", type="string")
 * )
 */