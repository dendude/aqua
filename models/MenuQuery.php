<?php

namespace app\models;

use app\helpers\Statuses;
use Yii;
use yii\db\ActiveQuery;

class MenuQuery extends ActiveQuery
{
    public function active() {
        $this->andWhere(['status' => Statuses::STATUS_ACTIVE]);
        $this->orderBy(['ordering' => SORT_ASC]);
        return $this;
    }

    public function root() {
        $this->andWhere(['parent_id' => 0]);
        $this->orderBy('ordering ASC');
        return $this;
    }

    public function top1() {
        $this->andWhere(['parent_id' => Menu::TOP_MENU_1]);
        return $this;
    }
    public function top2() {
        $this->andWhere(['parent_id' => Menu::TOP_MENU_2]);
        return $this;
    }
    public function top3() {
        $this->andWhere(['parent_id' => Menu::TOP_MENU_3]);
        return $this;
    }
    
    public function byParent($parent_id) {
        $this->andWhere(['parent_id' => $parent_id]);
        return $this;
    }

    public function sidebar($parent_id) {
        $this->andWhere(['parent_id' => $parent_id]);
        return $this;
    }

    public function footer() {
        $this->andWhere(['parent_id' => Menu::FOOTER_MENU]);
        return $this;
    }
}