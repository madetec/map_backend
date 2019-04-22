<?php

namespace backend\forms;

use uztelecom\entities\orders\Order;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * @property array $colors
 */
class OrderSearch extends Model
{
    public $status;
    public $user;
    public $driver;
    public $created_at;

    public function rules()
    {
        return [
            [['status', 'created_at'], 'integer'],
            [['user', 'driver'], 'string'],
        ];
    }


    /**
     * @param array $params
     * @return ActiveDataProvider
     * @throws \yii\base\InvalidArgumentException
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Order::find()->alias('o')->orderBy(['created_at' => SORT_DESC]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }
        $query->andFilterWhere([
            'o.status' => $this->status,
        ]);

        if ($this->user) {
            $query->innerJoin('{{%profiles}} u', 'o.created_by = u.user_id');
            $query->andFilterWhere([
                'or',
                ['like', 'u.name', $this->user],
                ['like', 'u.last_name', $this->user],
                ['like', 'u.father_name', $this->user],
            ]);
        }
        if ($this->driver) {
            $query->innerJoin('{{%profiles}} d', 'o.created_by = d.user_id');
            $query->andFilterWhere([
                'or',
                ['like', 'd.name', $this->user],
                ['like', 'd.last_name', $this->user],
                ['like', 'd.father_name', $this->user],
            ]);
        }
//
//        $query->andFilterWhere(['like', 'model', $this->model])
//            ->andFilterWhere(['like', 'number', $this->number]);

        return $dataProvider;
    }


}
