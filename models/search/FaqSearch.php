<?php

namespace app\models\search;

use app\models\Faq;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class FaqSearch extends Faq {

    public function rules()
    {
        return [
            [['id', 'section_id', 'manager_id', 'user_id', 'created', 'ordering', 'status', 'send_answer'], 'integer'],
            [['name', 'email', 'question_text', 'answer_text'], 'string'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Faq::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ],
            ],
            'pagination' => [
                'pageSize' => 20,
            ]
        ]);

        // load the seach form data and validate
        if (!$this->load($params)) {
            return $dataProvider;
        }

        // adjust the query by adding the filters
        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['section_id' => $this->section_id]);
        $query->andFilterWhere(['user_id' => $this->user_id]);
        $query->andFilterWhere(['manager_id' => $this->manager_id]);
        $query->andFilterWhere(['status' => $this->status]);
        $query->andFilterWhere(['send_answer' => $this->send_answer]);
        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'email', $this->email]);
        $query->andFilterWhere(['like', 'question_text', $this->question_text]);
        $query->andFilterWhere(['like', 'answer_text', $this->answer_text]);

        return $dataProvider;
    }
}