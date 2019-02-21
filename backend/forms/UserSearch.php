<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace backend\forms;


use uztelecom\entities\Subdivision;
use uztelecom\entities\user\User;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;

class UserSearch extends Model
{
    public $id;
    public $username;
    public $status;
    public $role;
    public $fullName;
    public $subdivision;

    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['username', 'role', 'fullName', 'subdivision'], 'safe'],
        ];
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     * @throws \yii\base\InvalidArgumentException
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = User::find()->alias('u');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        if (!$this->validate()) {
            $query->where('0=1');
            return $dataProvider;
        }
        $query->andFilterWhere([
            'u.id' => $this->id,
            'u.status' => $this->status,
        ]);

        $query->innerJoin('{{%profiles}} p', 'p.user_id = u.id');

        if ($this->fullName) {
            $query->andFilterWhere([
                'or',
                ['like', 'p.name', $this->fullName],
                ['like', 'p.last_name', $this->fullName],
                ['like', 'p.father_name', $this->fullName],
            ]);
        }

        if ($this->subdivision) {
            $query->innerJoin('{{%subdivisions}} s', 's.id = p.subdivision_id');
            $query->andFilterWhere(['s.id' => $this->subdivision]);
        }

        $query
            ->andFilterWhere(['like', 'u.username', $this->username])
            ->andFilterWhere(['like', 'u.role', $this->role]);
        return $dataProvider;
    }

    public function rolesList(): array
    {
        return ArrayHelper::map(\Yii::$app->authManager->getRoles(), 'name', 'description');
    }

    public function subdivisionsList(): array
    {
        return ArrayHelper::map(Subdivision::find()->asArray()->all(), 'id', 'name');
    }
}