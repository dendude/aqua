<?php

namespace app\models\search;

use app\models\Reviews;
use app\models\Vars;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class VarsSearch extends Vars {

    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['value'], 'string'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Vars::find();

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
        $query->andFilterWhere(['like', 'value', $this->value]);

        return $dataProvider;
    }
}