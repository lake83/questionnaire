<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Results;

/**
 * ResultsSearch represents the model behind the search form of `app\models\Results`.
 */
class ResultsSearch extends Results
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'questionnaire_id'], 'integer'],
            ['created_at', 'date', 'format' => 'd.m.Y'],
            [['name', 'phone', 'questions', 'discount', 'referrer'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Results::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);
        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'id' => $this->id,
            'questionnaire_id' => $this->questionnaire_id,
            'FROM_UNIXTIME(created_at, "%d.%m.%Y")' => $this->created_at
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'questions', $this->questions])
            ->andFilterWhere(['like', 'discount', $this->discount])
            ->andFilterWhere(['like', 'referrer', $this->referrer]);

        return $dataProvider;
    }
}