<?php

namespace api\controllers;

use yii\rest\Controller;

/**
 * @SWG\Swagger(
 *     basePath="/",
 *     host="api.telecom-car.uz",
 *     schemes={"http"},
 *     produces={"application/json","application/xml"},
 *     consumes={"application/json","application/xml","application/x-www-form-urlencoded"},
 *     @SWG\Info(
 *         version="1.0.0",
 *         title="TelecomCar API",
 *         description="HTTP JSON API",
 *     ),
 *     @SWG\SecurityScheme(
 *         securityDefinition="OAuth2",
 *         type="oauth2",
 *         flow="password",
 *         tokenUrl="http://api.telecom-car.uz/oauth2/token"
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
            'name' => 'TelecomCar',
            'version' => '1.0.0',
        ];
    }
}

/**
 * @SWG\Post(
 *     path="/oauth2/token",
 *     tags={"Auth"},
 *     description="Login OR Refresh token",
 *     @SWG\Parameter(
 *          name="login data",
 *          in="body",
 *          required=false,
 *          type="object",
 *          @SWG\Schema(ref="#/definitions/RequestLogin")
 *     ),
 *     @SWG\Parameter(
 *          name="refresh token data",
 *          in="body",
 *          required=false,
 *          type="object",
 *          @SWG\Schema(ref="#/definitions/RequestRefreshToken")
 *     ),
 *     @SWG\Response(
 *         response="200",
 *         description="Response data",
 *         @SWG\Property(property="data", type="object", ref="#/definitions/ResponseAuth"),
 *     )
 * )
 *
 *
 * @SWG\Definition(
 *     definition="RequestRefreshToken",
 *     type="object",
 *     @SWG\Property(property="grant_type", type="number", enum="refresh_token"),
 *     @SWG\Property(property="refresh_token", type="string"),
 *     @SWG\Property(property="client_id", type="string", enum="testclient"),
 *     @SWG\Property(property="client_secret", type="string", enum="testpass"),
 * )
 * @SWG\Definition(
 *     definition="RequestLogin",
 *     type="object",
 *     @SWG\Property(property="grant_type", type="number", enum="password"),
 *     @SWG\Property(property="username", type="string"),
 *     @SWG\Property(property="password", type="string"),
 *     @SWG\Property(property="client_id", type="string", enum="testclient"),
 *     @SWG\Property(property="client_secret", type="string", enum="testpass"),
 * )
 * @SWG\Definition(
 *     definition="ResponseRefreshToken",
 *     type="object",
 *
 * )
 * @SWG\Definition(
 *     definition="ResponseAuth",
 *     type="object",
 *     @SWG\Property(property="refresh token data", type="object",
 *          @SWG\Property(property="access_token", type="string"),
 *          @SWG\Property(property="expired_in", type="integer"),
 *          @SWG\Property(property="token_type", type="string", enum="Bearer"),
 *          @SWG\Property(property="scope", type="string", enum="null"),
 *      ),
 *     @SWG\Property(property="login data", type="object",
 *          @SWG\Property(property="access_token", type="string"),
 *          @SWG\Property(property="expired_in", type="integer"),
 *          @SWG\Property(property="token_type", type="string", enum="Bearer"),
 *          @SWG\Property(property="refresh_token", type="string"),
 *          @SWG\Property(property="scope", type="string", enum="null"),
 *     ),
 * )
 */
