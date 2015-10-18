<?php

namespace app\models\search;

use app\helpers\Normalize;
use app\models\FreeTravel;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class FreeTravelSearch extends FreeTravel {

    public function rules()
    {
        return [
            [['name', 'email', 'comment', 'phone'], 'string'],
            [['id', 'manager_id', 'status', 'ordering', 'send_mail'], 'integer'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = FreeTravel::find();

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
        $query->andFilterWhere(['like', 'phone', Normalize::cleanPhone($this->phone)]);
        $query->andFilterWhere(['like', 'comment', $this->comment]);

        return $dataProvider;
    }
}