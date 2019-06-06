<?php


namespace uztelecom\forms;

use uztelecom\entities\Subdivision;
use yii\base\Model;


/**
 * Class SubdivisionForm
 * @package uztelecom\forms
 * @property string $name
 * @property float $lat
 * @property float $lng
 * @property string $address
 */
class SubdivisionForm extends Model
{
    public $name;
    public $lat;
    public $lng;
    public $address;

    public function __construct(Subdivision $subdivision = null, $config = [])
    {
        if ($subdivision) {
            $this->name = $subdivision->name;
            $this->lat = $subdivision->lat;
            $this->lng = $subdivision->lng;
            $this->address = $subdivision->address;
        }
        parent::__construct($config);
    }

    public function rules(): array
    {
        return [
            ['name', 'required'],
            [['lat', 'lng'], 'number'],
            [['name', 'address'], 'string']
        ];
    }
}