<?php
/**
 * Created by PhpStorm.
 * User: dendude
 * Date: 15.03.15
 * Time: 20:45
 */

namespace app\helpers;

use Yii;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * получение кнопок действий над записями
 * Class ManageList
 * @package app\helpers
 */
class ManageList {

    /**
     * @param $model - модель
     * @param array $add_buttons - дополнительные действия, будут расположены в порядке следования перед основными
     * @return string
     */
    public static function get($model, $add_buttons = [], $except_buttons = []) {

        $actions = [];
        $return = [];

        foreach ($add_buttons AS $btn_name) {
            // добавляем кнопки
            switch ($btn_name) {
                case 'show':
                    $actions[$btn_name] = ['icon' => 'search', 'class' => 'default', 'title' => 'Просмотр'];
                    break;
                case 'template-edit':
                case 'section-edit':
                    $actions[$btn_name] = ['icon' => 'pencil', 'class' => 'info', 'title' => 'Редактировать'];
                    break;
                case 'template-delete':
                case 'section-delete':
                    $actions[$btn_name] = ['icon' => 'trash', 'class' => 'danger', 'title' => 'Удалить'];
                    break;
            }
        }

        $actions['edit'] = ['icon' => 'pencil', 'class' => 'info', 'title' => 'Редактировать'];
        $actions['delete'] = ['icon' => 'trash', 'class' => 'danger', 'title' => 'Удалить'];

        foreach ($except_buttons AS $bnt_name) {
            // удаляем кнопки
            unset($actions[$bnt_name]);
        }

        foreach ($actions AS $ak => $av) {

            $act_url = Yii::$app->controller->id . '/' . $ak;  // пример: users/edit

            $return[] = Html::tag('a', '<i class="glyphicon glyphicon-' . $av['icon'] . '"></i>', [
                'href' => Url::to([$act_url, 'id' => $model->id]),
                'class' => 'btn btn-sm btn-' . $av['class'],
                'title' => $av['title'],
            ]);
        }

        return Html::tag('div', implode('', $return), ['class' => 'btn-group']);
    }
} 