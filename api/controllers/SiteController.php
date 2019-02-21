<?php

namespace api\controllers;

use yii\rest\Controller;

/**
 * @SWG\Swagger(
 *     basePath="/",
 *     host="api.map.madetec.uz",
 *     schemes={"http"},
 *     produces={"application/json","application/xml"},
 *     consumes={"application/json","application/xml","application/x-www-form-urlencoded"},
 *     @SWG\Info(
 *         version="1.0.0",
 *         title="Telecom Car API",
 *         description="HTTP JSON API",
 *     ),
 *     @SWG\SecurityScheme(
 *         securityDefinition="OAuth2",
 *         type="oauth2",
 *         flow="password",
 *         tokenUrl="http://api.map.madetec.uz/oauth2/token"
 *     ),
 *     @SWG\SecurityScheme(
 *         securityDefinition="Bearer",
 *         type="apiKey",
 *         name="Authorization",
 *         in="header"
 *     ),
 *     @SWG\Definition(
 *         definition="ErrorModel",
 *         type="object",
 *         required={"code", "message"},
 *         @SWG\Property(
 *             property="code",
 *             type="integer",
 *         ),
 *         @SWG\Property(
 *             property="message",
 *             type="string"
 *         )
 *     )
 * )
 */
class SiteController extends Controller
{
    /**
     * @SWG\Get(
     *     path="/",
     *     tags={"Info"},
     *     @SWG\Response(
     *         response="200",
     *         description="API version",
     *         @SWG\Schema(
     *             type="object",
     *             @SWG\Property(property="version", type="string")
     *         ),
     *     )
     * )
     */
    public function actionIndex()
    {
        return [
            'name' => 'Telecom Car',
            'version' => '1.0.0',
        ];
    }
}
