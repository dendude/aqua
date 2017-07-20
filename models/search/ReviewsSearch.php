<?php

namespace app\models\search;

use app\models\Reviews;
use Yii;
use yii\data\ActiveDataProvider;

class ReviewsSearch extends Reviews {

    public function rules()
    {
        return [
            [['id', 'manager_id', 'created', 'modified', 'status', 'ordering'], 'integer'],
            [['name', 'email', 'comment'], 'string'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return parent::scenarios();
    }

    public function search($params)
    {
        $query = parent::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'ordering' => SORT_ASC,
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
        $query->andFilterWhere(['manager_id' => $this->manager_id]);
        $query->andFilterWhere(['ordering' => $this->ordering]);
        $query->andFilterWhere(['status' => $this->status]);

        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'email', $this->email]);
        $query->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}