<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%orders}}".
 *
 * @property integer $id
 * @property integer $manager_id
 * @property integer $aqua_type
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property integer $view_type
 * @property integer $service_type
 * @property string $comment
 * @property integer $created
 * @property integer $modified
 * @property integer $status
 */
class Orders extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%orders}}';
    }

    public function getManager() {
        return $this->hasOne(Users::className(), ['id' => 'manager_id']);
    }

    public static function getViewTypes() {
        return [
            0 => 'Не выбран',
            1 => 'ДСП, черный ламинат',
            2 => 'ДСП, серый ламинат',
            3 => 'Мебельный пластик',
            4 => 'Влагостойкий шпон',
            5 => 'Укажу позже в договоре',
        ];
    }
    public static function getViewName($view_id) {
        $list = self::getViewTypes();
        return isset($list[$view_id]) ? $list[$view_id] : 'не найден';
    }

    public static function getServicesTypes() {
        return [
            0 => 'Не выбран',
            1 => 'Базовая комплектация',
            2 => 'Базовая с оборудованием',
            3 => 'С оборудованием и оформлением',
            4 => 'С оформлением и обслуживанием',
            5 => 'Укажу позже в договоре',
        ];
    }
    public static function getServiceName($service_id) {
        $list = self::getServicesTypes();
        return isset($list[$service_id]) ? $list[$service_id] : 'не найден';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['aqua_type', 'name', 'email', 'created'], 'required'],

            ['email', 'email'],

            [['manager_id', 'view_type', 'service_type', 'created', 'modified', 'status'], 'integer'],
            [['manager_id', 'view_type', 'service_type', 'created', 'modified', 'status'], 'default', 'value' => 0],

            [['name', 'email', 'aqua_type'], 'string', 'max' => 200],

            [['phone'], 'string', 'min' => 10, 'max' => 20],

            [['comment'], 'string', 'max' => 500]
        ];
    }

    public function beforeValidate()
    {
        if ($this->isNewRecord) {
            $this->created = time();
        } else {
            $this->modified = time();

            if (Users::isManager()) $this->manager_id = Yii::$app->user->id;
        }

        return parent::beforeValidate();
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'manager_id' => 'Менеджер',
            'aqua_type' => 'Тип аквариума',
            'name' => 'Ваше Имя',
            'email' => 'Ваш Email',
            'phone' => 'Ваш телефон',
            'view_type' => 'Выберите вариант отделки',
            'service_type' => 'Выберите комплектацию и услуги',
            'comment' => 'Комментарий к заказу',
            'created' => 'Создан',
            'modified' => 'Изменен',
            'status' => 'Статус',
        ];
    }

    /**
     * @inheritdoc
     * @return OrdersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OrdersQuery(get_called_class());
    }
}
