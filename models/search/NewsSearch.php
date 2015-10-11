<?php

namespace app\models\search;

use app\models\Pages;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use \app\models\News;

class NewsSearch extends News {

    public function rules()
    {
        return [
            [['id', 'section_id', 'manager_id', 'ordering', 'status', 'is_slider'], 'integer'],
            [['title', 'alias', 'menu_title'], 'string'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = News::find();

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
        $query->andFilterWhere(['section_id' => $this->section_id]);
        $query->andFilterWhere(['manager_id' => $this->manager_id]);
        $query->andFilterWhere(['ordering' => $this->ordering]);
        $query->andFilterWhere(['status' => $this->status]);
        $query->andFilterWhere(['is_slider' => $this->is_slider]);
        $query->andFilterWhere(['like', 'title', $this->title]);
        $query->andFilterWhere(['like', 'alias', $this->alias]);
        $query->andFilterWhere(['like', 'menu_title', $this->menu_title]);

        return $dataProvider;
    }
}