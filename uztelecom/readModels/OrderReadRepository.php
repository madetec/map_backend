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
    /**
     * @param $user_id
     * @return Order|null
     */
    public function findActiveOrder($user_id): ?Order
    {
        /** @var Order $order */
        $order = Order::find()
            ->where(['created_by' => $user_id])
            ->andWhere(['!=', 'status', [Order::STATUS_CANCELED, Order::STATUS_COMPLETED]])
            ->one();
        return $order;
    }

    public function findAll($id = null)
    {
        $query = Order::find()->orderBy(['created_at' => SORT_DESC]);
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