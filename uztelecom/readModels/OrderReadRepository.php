<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace uztelecom\readModels;
use uztelecom\entities\orders\Order;
use uztelecom\exceptions\NotFoundException;
use yii\data\ActiveDataProvider;

class OrderReadRepository
{
    /**
     * @param $user_id
     * @return Order|null
     * @throws NotFoundException
     */
    public function findActiveOrder($user_id): ?Order
    {
        /** @var Order $order */
        if (!$user_id) {
            throw new  NotFoundException('User not found.');
        }
        if (!$order = Order::find()
            ->where([
                'and',
                ['created_by' => $user_id],
                [
                    'or',
                    ['!=', 'status', Order::STATUS_CANCELED],
                    ['!=', 'status', Order::STATUS_COMPLETED],
                ]
            ])
            ->one()) {
            throw new  NotFoundException('Order not found.');
        }
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