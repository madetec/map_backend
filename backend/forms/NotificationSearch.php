<?php

namespace backend\forms;

use uztelecom\entities\notification\Notification;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class NotificationSearch extends Model
{
    public $from_id;
    public $item_id;

    public function rules()
    {
        return [
            [['from_id','item_id'], 'integer'],
        ];
    }


    public function search(array $params): ActiveDataProvider
    {
        $query = Notification::find()->alias('n');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }
        $query->andFilterWhere([
            'n.from_id' => $this->from_id,
            'n.item_id' => $this->item_id,
        ]);

//        $query->innerJoin('{{%profiles}} p', 'c.user_id = p.user_id');
//
//        if ($this->user_id) {
//            $query->andFilterWhere([
//                'or',
//                ['like', 'p.name', $this->user_id],
//                ['like', 'p.last_name', $this->user_id],
//                ['like', 'p.father_name', $this->user_id],
//            ]);
//        }


        return $dataProvider;
    }
}
