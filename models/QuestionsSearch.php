<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Questions;

/**
 * QuestionsSearch represents the model behind the search form of `app\models\Questions`.
 */
class QuestionsSearch extends Questions
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'questionnaire_id', 'type', 'position', 'is_required', 'is_several', 'is_active'], 'integer'],
            ['created_at', 'date', 'format' => 'd.m.Y'],
            [['name', 'hint', 'image'], 'safe']
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
        $query = Questions::find()->where(['questionnaire_id' => $params['questionnaire_id']]);

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
            'type' => $this->type,
            'position' => $this->position,
            'is_required' => $this->is_required,
            'is_several' => $this->is_several,
            'is_active' => $this->is_active,
            'FROM_UNIXTIME(created_at, "%d.%m.%Y")' => $this->created_at
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'hint', $this->hint])
            ->andFilterWhere(['like', 'image', $this->image]);

        return $dataProvider;
    }
}