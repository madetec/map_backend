<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace uztelecom\readModels;


use uztelecom\entities\notification\Notification;
use uztelecom\entities\notification\NotificationAssignments;
use yii\data\ActiveDataProvider;
use yii\db\ActiveQuery;

class NotificationReadModel
{

    /**
     * @param $user_id
     * @param $dataProvider
     * @return ActiveDataProvider|\yii\db\ActiveQuery
     */

    public function findAllNewNotifications($user_id, $dataProvider = null)
    {
        $query = Notification::find()->alias('notification');
        $query->innerJoin(
            NotificationAssignments::tableName() . ' assignments',
            'assignments.notification_id = notification.id');
        $query->andWhere(['assignments.to_id' => $user_id]);
        $query->andWhere(['assignments.status' => NotificationAssignments::STATUS_UNREAD]);
        return $dataProvider ? $this->getProvider($query) : $query;
    }

    public function findAllByUserId($user_id)
    {
        $query = Notification::find()->alias('n');
        $query->innerJoin(
            NotificationAssignments::tableName() . ' a',
            'a.notification_id = n.id');
        $query->andWhere(['a.to_id' => $user_id]);
        $query->orderBy(['created_at' => SORT_DESC]);
        return $this->getProvider($query);
    }


    protected function getProvider($query)
    {
        return new ActiveDataProvider([
            'query' => $query
        ]);
    }
}