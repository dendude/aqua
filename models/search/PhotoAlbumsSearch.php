<?php

namespace app\models\search;

use app\models\PhotoAlbums;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

class PhotoAlbumsSearch extends PhotoAlbums {

    public function rules()
    {
        return [
            [['id', 'manager_id', 'ordering', 'status'], 'integer'],
            [['name'], 'string'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return PhotoAlbums::scenarios();
    }

    public function search($params)
    {
        $query = PhotoAlbums::find();

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
        $query->andFilterWhere(['like', 'name', $this->title]);

        return $dataProvider;
    }
}