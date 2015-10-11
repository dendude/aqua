<?php

namespace app\models\search;

use app\helpers\Statuses;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Users;

class UsersSearch extends Users {

    public function rules()
    {
        return [
            [['id', 'status'], 'integer'],
            [['role', 'name', 'email', 'phone'], 'string'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Users::find()->where('status != :removed', [':removed' => Statuses::STATUS_REMOVED]);

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
        $query->andFilterWhere(['role' => $this->role]);
        $query->andFilterWhere(['status' => $this->status]);
        $query->andFilterWhere(['like', 'name', $this->name]);
        $query->andFilterWhere(['like', 'email', $this->email]);
        $query->andFilterWhere(['like', 'phone', preg_replace('/[^0-9]+/','',$this->phone)]);

        return $dataProvider;
    }
}