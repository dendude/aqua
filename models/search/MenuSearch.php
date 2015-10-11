<?php

namespace app\models\search;

use app\models\Menu;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class MenuSearch extends Menu {

    public function rules()
    {
        return [
            [['id', 'id_author', 'parent_id', 'page_id', 'ordering', 'status'], 'integer'],
            [['menu_name', 'menu_title'], 'string']
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Menu::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'parent_id' => SORT_ASC,
                    'ordering' => SORT_ASC,
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
        $query->andFilterWhere(['parent_id' => $this->parent_id]);
        $query->andFilterWhere(['page_id' => $this->page_id]);
        $query->andFilterWhere(['ordering' => $this->ordering]);
        $query->andFilterWhere(['status' => $this->status]);
        $query->andFilterWhere(['like', 'menu_name', $this->menu_name]);
        $query->andFilterWhere(['like', 'menu_title', $this->menu_title]);

        return $dataProvider;
    }
}