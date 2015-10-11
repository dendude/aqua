<?php

namespace app\models;

use app\helpers\Statuses;
use Yii;
use yii\db\ActiveQuery;

class MenuQuery extends ActiveQuery
{
    public function active() {
        $this->andWhere(['status' => Statuses::STATUS_ACTIVE]);
        $this->andWhere('page_id != 0');
        $this->orderBy('ordering ASC');
        return $this;
    }

    public function root() {
        $this->andWhere(['parent_id' => 0]);
        return $this;
    }

    public function top() {
        $this->andWhere(['parent_id' => 1]);
        return $this;
    }

    public function sidebar() {
        $this->andWhere(['parent_id' => 3]);
        return $this;
    }
}