<?php

namespace backend\forms;

use uztelecom\entities\cars\Car;
use uztelecom\entities\Color;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

/**
 * @property array $colors
 */

class CarSearch extends Model
{
    public $user_id;
    public $model;
    public $color_id;
    public $number;

    public function rules()
    {
        return [
            [['color_id'], 'integer'],
            [['number', 'model','user_id'], 'safe'],
        ];
    }


    public function search(array $params): ActiveDataProvider
    {
        $query = Car::find()->alias('c');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }
        $query->andFilterWhere([
            'c.color_id' => $this->color_id,
        ]);

        $query->innerJoin('{{%profiles}} p', 'c.user_id = p.user_id');

        if ($this->user_id) {
            $query->andFilterWhere([
                'or',
                ['like', 'p.name', $this->user_id],
                ['like', 'p.last_name', $this->user_id],
                ['like', 'p.father_name', $this->user_id],
            ]);
        }

        $query->andFilterWhere(['like', 'model', $this->model])
            ->andFilterWhere(['like', 'number', $this->number]);

        return $dataProvider;
    }


    public function getColors()
    {
        return ArrayHelper::map(Color::find()->asArray()->all(),'id', 'name');
    }
}
