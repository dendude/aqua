<?php

namespace app\models;

use app\helpers\Statuses;
use Yii;
use yii\db\ActiveQuery;

class VideosQuery extends ActiveQuery
{
    public function active() {
        $this->andWhere(['status' => Statuses::STATUS_ACTIVE]);
        return $this;
    }
    
    public function ordering() {
        $this->orderBy(['ordering' => SORT_ASC]);
        return $this;
    }

    public function manage() {
        $this->andWhere('status != :status', [':status' => Statuses::STATUS_REMOVED]);
        return $this;
    }
}