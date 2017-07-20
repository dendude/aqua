<?php

namespace app\models;
use app\helpers\Statuses;
use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[Reviews]].
 *
 * @see Reviews
 */
class ReviewsQuery extends ActiveQuery
{
    public function waiting()
    {
        $this->andWhere(['status' => Statuses::STATUS_DISABLED]);
        return $this;
    }

    public function active()
    {
        $this->andWhere(['status' => Statuses::STATUS_ACTIVE]);
        return $this;
    }

    public function ordering()
    {
        $this->orderBy(['ordering' => SORT_ASC, 'created' => SORT_DESC]);
        return $this;
    }
}