<?php

namespace app\widgets;
use app\helpers\Statuses;
use app\models\ActionsSections;
use app\models\forms\LoginForm;
use app\models\NewsSections;
use app\models\PhotoAlbums;
use app\models\ResultsSections;
use yii\base\Widget;
use yii\bootstrap\Modal;
use yii\helpers\Html;

class MainWidgets extends Widget {

    const TYPE_DEFAULT = 'default';
    const TYPE_NEWS = 'news';
    const TYPE_RESULTS = 'results';
    const TYPE_ACTIONS = 'actions';
    const TYPE_GALLERY = 'gallery';

    public $type;

	public function init() {

        switch ($this->type) {
            case self::TYPE_NEWS :
                $data = NewsSections::find()
                    ->where(['status' => Statuses::STATUS_ACTIVE])
                    ->orderBy(['ordering' => SORT_ASC])
                    ->all();
                break;

            case self::TYPE_RESULTS :
                $data = ResultsSections::find()
                    ->where(['status' => Statuses::STATUS_ACTIVE])
                    ->orderBy(['ordering' => SORT_ASC])
                    ->all();
                break;

            case self::TYPE_ACTIONS :
                $data = ActionsSections::find()
                    ->where(['status' => Statuses::STATUS_ACTIVE])
                    ->orderBy(['ordering' => SORT_ASC])
                    ->all();
                break;

            case self::TYPE_GALLERY :
                $data = PhotoAlbums::find()
                    ->where(['status' => Statuses::STATUS_ACTIVE])
                    ->orderBy(['ordering' => SORT_ASC, 'id' => SORT_DESC])
                    ->all();
                break;


            default:
                $data = null;
        }

		echo $this->render(
            'MainWidgets', [
                'type' => $this->type,
                'data' => $data,
            ]
        );
	}
}