<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Questionnaires;

/**
 * QuestionnairesSearch represents the model behind the search form of `app\models\Questionnaires`.
 */
class QuestionnairesSearch extends Questionnaires
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'is_column', 'is_discount', 'discount_type'], 'integer'],
            ['created_at', 'date', 'format' => 'd.m.Y'],
            [['title', 'person_name', 'person_image', 'person_post', 'discount_info'], 'safe'],
            ['discount_value', 'number']
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
        $query = Questionnaires::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'id' => $this->id,
            'is_column' => $this->is_column,
            'is_discount' => $this->is_discount,
            'discount_type' => $this->discount_type,
            'discount_value' => $this->discount_value,
            'FROM_UNIXTIME(created_at, "%d.%m.%Y")' => $this->created_at
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'person_name', $this->person_name])
            ->andFilterWhere(['like', 'person_image', $this->person_image])
            ->andFilterWhere(['like', 'person_post', $this->person_post])
            ->andFilterWhere(['like', 'discount_info', $this->discount_info]);

        return $dataProvider;
    }
}