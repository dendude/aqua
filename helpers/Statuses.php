<?php
/**
 * Created by PhpStorm.
 * User: dendude
 * Date: 15.03.15
 * Time: 20:45
 */

namespace app\helpers;

use yii\helpers\Html;

class Statuses {

    const STATUS_DISABLED = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_USED = 2;
    const STATUS_REMOVED = 10;

    const TYPE_FEEDBACK = 'feedback';
    const TYPE_PROCESSED = 'processed';
    const TYPE_YESNO = 'yesno';
    const TYPE_ACTREM = 'actrem';
    const TYPE_ACTIVE = 'active';

    public static function statuses($type = null) {

        $statuses = [];

        switch ($type) {
            case self::TYPE_FEEDBACK:
                $statuses = array(
                    self::STATUS_DISABLED => 'Новый',
                    self::STATUS_USED => 'Просмотрен',
                    self::STATUS_ACTIVE => 'Отвечен',
                );
                break;

            case self::TYPE_PROCESSED:
                $statuses = array(
                    self::STATUS_DISABLED => 'Новый',
                    self::STATUS_USED => 'Просмотрен',
                    self::STATUS_ACTIVE => 'Обработан',
                );
                break;

            case self::TYPE_YESNO:
                $statuses = array(
                    self::STATUS_ACTIVE => 'Да',
                    self::STATUS_DISABLED => 'Нет',
                );
                break;

            case self::TYPE_ACTREM:
                $statuses = array(
                    self::STATUS_ACTIVE => 'Активен',
                    self::STATUS_DISABLED => 'Удалён',
                );
                break;

            case self::TYPE_ACTIVE:
                $statuses = array(
                    self::STATUS_ACTIVE => 'Активен',
                    self::STATUS_DISABLED => 'Неактивен',
                );
                break;

            default:
                $statuses = array(
                    self::STATUS_ACTIVE => 'Активен',
                    self::STATUS_DISABLED => 'Скрыт',
                );
        }

        return $statuses;
    }

    public static function labels() {
        return array(
            self::STATUS_USED => 'primary',
            self::STATUS_ACTIVE => 'success',
            self::STATUS_DISABLED => 'default',
        );
    }

    public static function getName($status_id, $type = null) {
        $list = self::statuses($type);
        return isset($list[$status_id]) ? $list[$status_id] : '';
    }

    public static function getLabel($status_id) {
        $list = self::labels();
        return isset($list[$status_id]) ? $list[$status_id] : '';
    }

    public static function getFull($status_id, $type = null) {
        return Html::tag('span', self::getName($status_id, $type), ['class' => 'label label-' . self::getLabel($status_id)]);
    }
} 