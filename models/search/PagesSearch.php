<?php

namespace app\models\search;

use app\models\Menu;
use app\models\Pages;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class PagesSearch extends Pages {

    public function rules()
    {
        return [
            [['id', 'id_author', 'status'], 'required'],
            [['is_sitemap', 'is_auto', 'is_shared'], 'boolean'],
            [['title', 'alias'], 'string'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Pages::find();

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
        $query->andFilterWhere(['id_author' => $this->id_author]);
        $query->andFilterWhere(['status' => $this->status]);
        $query->andFilterWhere(['is_auto' => $this->is_auto]);
        $query->andFilterWhere(['is_sitemap' => $this->is_sitemap]);
        $query->andFilterWhere(['is_shared' => $this->is_shared]);
        $query->andFilterWhere(['like', 'title', $this->title]);
        $query->andFilterWhere(['like', 'alias', $this->alias]);

        return $dataProvider;
    }
}