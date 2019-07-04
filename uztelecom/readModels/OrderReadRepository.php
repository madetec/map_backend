<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace uztelecom\readModels;
use uztelecom\entities\orders\Order;
use uztelecom\exceptions\NotFoundException;
use yii\base\Component;
use yii\data\ActiveDataProvider;

/**
 * @property $totalCount
 */
class OrderReadRepository extends Component
{

    /**
     * @param $user_id
     * @return Order|null
     * @throws NotFoundException
     */
    public function findActiveOrderForDriver($user_id): ?Order
    {
        /** @var Order $order */
        if (!$user_id) {
            throw new  NotFoundException('User not found.');
        }
        if (!$order = Order::find()
            ->where([
                'and',
                ['driver_id' => $user_id],
                ['status' => [
                    Order::STATUS_DRIVER_ON_THE_ROAD,
                    Order::STATUS_DRIVER_IS_WAITING,
                    Order::STATUS_DRIVER_STARTED_THE_RIDE,
                ]]
            ])
            ->one()) {
            throw new  NotFoundException('Order not found.');
        }
        return $order;
    }


    public function getTotalCount()
    {
        return Order::find()->count();
    }

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
                ['status' =>  [
                    Order::STATUS_ACTIVE,
                    Order::STATUS_DRIVER_ON_THE_ROAD,
                    Order::STATUS_DRIVER_IS_WAITING,
                    Order::STATUS_DRIVER_STARTED_THE_RIDE,
                ]]
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
