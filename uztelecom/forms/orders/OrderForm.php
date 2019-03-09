<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace uztelecom\forms\orders;

use yii\base\Model;

/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 * Class OrderForm
 * @package uztelecom\forms\orders
 */
class OrderForm extends Model
{
    public $from_lat;
    public $from_lng;
    public $from_address;
    public $to_lat;
    public $to_lng;
    public $to_address;

    public function rules()
    {
        return [
            [['from_lat', 'from_lng', 'from_address'], 'required'],
            [['from_lat', 'from_lng', 'to_lat', 'to_lng'], 'number'],
            [['from_address', 'to_address'], 'string', 'max' => 255],
        ];
    }
}