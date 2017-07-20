<?php

namespace app\widgets;

use app\models\Reviews;
use yii\base\Widget;
use yii\data\Pagination;

class ReviewsList extends Widget {

	public function run() {
	    
	    $query = Reviews::find()->active()->ordering();
        $count = $query->count();
        
        // create a pagination object with the total count
        $pagination = new Pagination(['totalCount' => $count, 'pageSize' => 10]);
        
        // limit the query using the pagination and retrieve the articles
        $models = $query->offset($pagination->offset)
                        ->limit($pagination->limit)
                        ->all();
	    
		return $this->render(
            'ReviewsList', [
                'models' => $models,
                'pagination' => $pagination
            ]
        );
	}
}