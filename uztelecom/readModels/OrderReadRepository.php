<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace uztelecom\readModels;
use uztelecom\entities\orders\Order;
use yii\data\ActiveDataProvider;

class OrderReadRepository
{
    public function findAll($id = null)
    {
        $query = Order::find();
        if ($id) {
            $query->andWhere(['created_by' => $id]);
        }
        return new ActiveDataProvider([
            'query' => $query
        ]);
    }

    public function find($id): ?Order
    {
        return Order::findOne($id);
    }
}