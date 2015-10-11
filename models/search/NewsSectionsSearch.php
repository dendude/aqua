<?php

namespace app\models\search;

use app\models\NewsSections;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use \app\models\FaqSections;

class NewsSectionsSearch extends NewsSections {

    public function rules()
    {
        return [
            [['id', 'section_id', 'manager_id', 'ordering', 'status'], 'integer'],
            [['name'], 'string']
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = NewsSections::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'ordering' => SORT_ASC,
                ],
            ],
            'pagination' => [
                'pageSize' => 20,
            ]
        ]);

        // load the seach form data and validate
        if (!$this->load($params)) return $dataProvider;

        // adjust the query by adding the filters
        $query->andFilterWhere(['id' => $this->id]);
        $query->andFilterWhere(['section_id' => $this->section_id]);
        $query->andFilterWhere(['manager_id' => $this->manager_id]);
        $query->andFilterWhere(['ordering' => $this->ordering]);
        $query->andFilterWhere(['status' => $this->status]);
        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}