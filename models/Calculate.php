<?php

namespace app\models;

use app\components\ReCaptcha;
use app\components\SmtpEmail;
use app\helpers\Statuses;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%feedback}}".
 *
 * @property integer $id
 * @property integer $id_user
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $subject
 * @property string $message
 * @property integer $created
 * @property integer $status
 */
class Calculate extends ActiveRecord
{
    const PAGE_ID = 183;
    
    const SCENARIO_SITE = 'site';
    
    public $param_length;
    public $param_width;
    public $param_height;

    public $param_has_krishka;
    public $param_has_tumba;
    public $param_has_oborud;
    public $param_oform_type;

    public $dop_params = ['param_length', 'param_width', 'param_height', 'param_has_krishka', 'param_has_tumba', 'param_has_oborud', 'param_oform_type'];
    
    public $captcha;
    
    public static function tableName()
    {
        return '{{%calculate}}';
    }

    public function rules()
    {
        return [
            [['name', 'email'], 'required'],
            [['answer'], 'required', 'when' => function($model){
                return $model->status == Statuses::STATUS_ACTIVE;
            }, 'message' => 'Чтобы отправить {attribute}, необходимо заполнить его'],

            [['manager_id', 'created', 'modified', 'answered', 'status', 'param_oform_type'], 'integer'],
            [['manager_id', 'created', 'modified', 'answered', 'status', 'param_oform_type'], 'default', 'value' => 0],

            [['email'], 'email'],

            [['param_length', 'param_width', 'param_height'], 'required', 'message' => 'Обязательно для ввода'],
            [['param_length', 'param_width', 'param_height'], 'filter', 'filter' => function($value){ return str_replace(',', '.', $value); }],
            [['param_length', 'param_width', 'param_height'], 'number', 'min' => 10,
                                                                    'message' => 'Введите число',
                                                                   'tooSmall' => 'Введите число, не менее {min}',
                                                              'numberPattern' => '/^\s*[-+]?[0-9]*[\.,]?[0-9]+([eE][-+]?[0-9]+)?\s*$/'],

            [['param_has_krishka', 'param_has_tumba', 'param_has_oborud'], 'boolean'],
            [['param_oform_type'], 'integer'],

            [['message', 'answer', 'params'], 'string'],
            [['message', 'answer', 'params'], 'default', 'value' => ''],

            [['name', 'email'], 'string', 'max' => 100],
            [['name', 'email'], 'default', 'value' => ''],

            [['phone'], 'string', 'min' => 10, 'max' => 20],
            [['phone'], 'default', 'value' => ''],

            ['captcha', 'required', 'message' => 'Необходимо отметить поле "Я не робот"', 'on' => self::SCENARIO_SITE],
            ['captcha', 'checkCaptcha', 'on' => self::SCENARIO_SITE],
        ];
    }
    
    public function checkCaptcha($attribute, $params) {
        $re_captcha = new ReCaptcha($this->{$attribute});
        if (!$re_captcha->validate()) {
            $this->addError($attribute, 'Некорректное значение reCaptcha');
        }
    }

    public static function getOformTypes() {
        return [
            1 => 'Пресноводное простое',
            2 => 'С живыми растениями',
            3 => 'Псевдоморе',
            4 => 'Морское',
            5 => 'Голландское',
            6 => 'Рифовое',
        ];
    }

    public static function getOformName($oform_type) {
        $list = self::getOformTypes();
        return isset($list[$oform_type]) ? $list[$oform_type] : 'Не найден';
    }

    public function getManager() {
        return $this->hasOne(Users::className(), ['id' => 'manager_id']);
    }

    public function beforeValidate()
    {
        if ($this->isNewRecord) {
            $this->created = time();
        } else {
            $this->manager_id = Yii::$app->user->id;
            $this->modified = time();
            if ($this->status == Statuses::STATUS_ACTIVE) {
                $this->answered = time();
            }
        }

        return parent::beforeValidate();
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        $params_values = [];
        $params_names = [];

        foreach ($this->dop_params AS $name) {
            if (!empty($this->$name)) {
                $params_values[$name] = $this->$name;
                $params_names[] = $this->getAttributeLabel($name);
            }
        }

        if (count($params_values)) $this->params = serialize($params_values);

        $mail_params = ['{name}' => $this->name,
                        '{email}' => $this->email,
                        '{phone}' => !empty($this->phone) ? $this->phone : 'Не указан',
                        '{sizes}' => implode(' x ', array_slice($params_values, 0, 3)),
                        '{view_type}' => $this->getOformName($this->param_oform_type),
                        '{accessories}' => implode(', ', array_slice($params_names, 3)),
                        '{comment}' => !empty($this->message) ? nl2br($this->message) : 'Не указан'];

        if ($this->isNewRecord) {
            $smtp = new SmtpEmail();
            $smtp->sendEmailByType(SmtpEmail::TYPE_CALCULATE, $this->email, $this->name, $mail_params);
        } else {
            $self = self::findOne($this->id);
            // отправляем письмо один раз
            if ($this->status == Statuses::STATUS_ACTIVE) {
                $smtp = new SmtpEmail();
                $smtp->sendEmailByType(SmtpEmail::TYPE_CALCULATE_ANSWER, $this->email, $this->name,
                                        array_merge($mail_params, ['{result}' => nl2br($this->answer)], false));
            } else {
                $this->status = $self->status;
            }
        }

        return parent::save($runValidation, $attributeNames);
    }

    public function afterFind()
    {
        if ($this->params) {
            $params = unserialize($this->params);
            foreach ($params AS $pk => $pv) {
                $this->{$pk} = $pv;
            }
        }

        parent::afterFind();
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'manager_id' => 'Менеджер',
            'name' => 'Имя',
            'email' => 'Email',
            'phone' => 'Телефон',
            'message' => 'Комментарий',
            'answer' => 'Ответ',
            'created' => 'Создан',
            'modified' => 'Изменен',
            'answered' => 'Отвечен',
            'status' => 'Статус',

            'param_length' => 'Длина',
            'param_width' => 'Ширина',
            'param_height' => 'Высота',

            'param_has_krishka' => 'Крышка',
            'param_has_tumba' => 'Тумба',
            'param_has_oborud' => 'Оборудование',
            'param_oform_type' => 'Оформление',
        ];
    }
}
