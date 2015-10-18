<?php

namespace app\models\search;

use app\models\Callback;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class CallbackSearch extends Callback {

    public function rules()
    {
        return [
            [['id', 'manager_id', 'status'], 'integer'],
            [['name', 'email', 'phone', 'subject', 'message'], 'string'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Callback::find();

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
        $query->andFilterWhere(['manager_id' => $this->manager_id]);
        $query->andFilterWhere(['status' => $this->status]);
        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'email', $this->email]);
        $query->andFilterWhere(['like', 'phone', $this->phone]);
        $query->andFilterWhere(['like', 'subject', $this->subject]);
        $query->andFilterWhere(['like', 'message', $this->message]);

        return $dataProvider;
    }
}