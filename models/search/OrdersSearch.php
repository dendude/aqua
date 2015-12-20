<?php

namespace app\models\search;

use app\models\Orders;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class OrdersSearch extends Orders {

    public function rules()
    {
        return [
            [['id', 'manager_id', 'status', 'view_type', 'service_type'], 'integer'],
            [['name', 'email', 'phone', 'comment'], 'string'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Orders::find();

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
        $query->andFilterWhere(['view_type' => $this->view_type]);
        $query->andFilterWhere(['service_type' => $this->service_type]);
        $query->andFilterWhere(['status' => $this->status]);

        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'email', $this->email]);
        $query->andFilterWhere(['like', 'phone', $this->phone]);
        $query->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}