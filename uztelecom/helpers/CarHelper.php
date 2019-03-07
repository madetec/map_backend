<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace uztelecom\helpers;


use yii\helpers\Html;

class CarHelper
{
    public static function formatCarNumber($number)
    {
        $first = substr($number, 0, 2);
        $second = substr($number, 2, 3);
        $num = substr($number, 5, 3);
        return Html::tag(
            'p',
            Html::tag('b', Html::tag('span', $first, ['style' => 'border-right: 1px solid #cccccc; padding: 0px 5px;']) . " $second $num"),
            ['style' => 'padding: 5px; border: 1px solid #cccccc; border-radius: 3px;']);
    }
}