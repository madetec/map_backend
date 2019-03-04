<?php

namespace uztelecom\forms\cars;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use uztelecom\entities\cars\Car;

/**
 * CarSearchForm represents the model behind the search form of `uztelecom\entities\cars\Car`.
 */
class CarSearchForm extends Car
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id'], 'integer'],
            [['model', 'color', 'number'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     * @throws \yii\base\InvalidArgumentException
     */
    public function search($params)
    {
        $query = Car::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'model', $this->model])
            ->andFilterWhere(['like', 'color', $this->color])
            ->andFilterWhere(['like', 'number', $this->number]);

        return $dataProvider;
    }
}
