<?php

namespace app\helpers;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\Html;

class MHtml {

	static $fId = 1;

	public static function checkBox($name, $label, $checked = false, $options = []) {

		$class = 'field-checkbox';

        if($checked) $class.= ' '.$class.'-checked';
        if (isset($options['class'])) $class.= ' '.$options['class'];
        $options['class'] = $class;

        if (!empty($options['readonly'])) $options['class'].= ' readonly';
        unset($options['readonly']);

        $value = isset($options['value']) ? $options['value'] : 1;
        unset($options['value']);

        $input_params = ['disabled' => !$checked];
        if (isset($options['id'])) $input_params['id'] = $options['id'];
        unset($options['id']);

        $tag = isset($options['tag']) ? $options['tag'] : 'a';
        unset($options['tag']);

        $content = $label . Html::hiddenInput($name, $value, $input_params);
        return Html::tag($tag, $content, $options);
	}

	public static function checkBoxList($name, $labels, $values, $selected = []) {

		$return = '';

		if(sizeof($labels) == sizeof($values)) {

			foreach($values AS $k => $v) {

				$class = 'field-checkbox';
				if(in_array($v, $selected))
					$class.= ' '.$class.'-checked';

				$row = Html::a($labels[$k], null, ['class' => $class, 'name' => $name]);
				$row.= Html::hiddenInput($name.'[]', $v, ['disabled' => !in_array($v, $selected)]);

				$return.= Html::tag('div', $row, ['class' => 'check-row']);
			}
		}		

		return $return;
	}

	public static function radioBox($name, $label, $checked = false, $options = []) {

		$class = 'field-radiobox';

        if($checked) $class.= ' '.$class.'-checked';
        if (isset($options['class'])) $class.= ' '.$options['class'];
        $options['class'] = $class;

        if (!empty($options['readonly'])) $options['class'].= ' readonly';
        unset($options['readonly']);

        $value = isset($options['value']) ? $options['value'] : 1;
        unset($options['value']);

        $input_params = ['disabled' => !$checked];
        if (isset($options['id'])) $input_params['id'] = $options['id'];
        unset($options['id']);

        $tag = isset($options['tag']) ? $options['tag'] : 'a';
        unset($options['tag']);

        $content = $label . Html::hiddenInput($name, $value, $input_params);
		return Html::tag($tag, $content, $options);
	}

	public static function radioBoxList($name, $labels, $values, $selected = 0) {

		$return = '';

		if(sizeof($labels) == sizeof($values)) {

			foreach($values AS $k => $v) {

				$class = 'field-radiobox';
				if($v == $selected) $class.= ' '.$class.'-checked';

				$row = Html::a($labels[$k], null, ['class' => $class, 'name' => $name]);
				$row.= Html::hiddenInput($name, $v, ['disabled' => ($v != $selected)]);

				$return.= Html::tag('div', $row, ['class' => 'radio-row']);
			}
		}

		return $return;
	}

	public static function selectBox($name, $values, $selected = 0, $firstLabel = '- Выбор -', $onChange = '') {

		$return = '<div id="sel_'.self::$fId.'" class="field-selectbox" onmousedown="wSelectBox(this)">';

		if(!empty($values)) {

			$selectedLabel = $selected && isset($values[$selected]) ? $values[$selected] : $firstLabel;

			$return.= '<table id="t_sel_'.self::$fId.'">'.
						'<tr>'.
							'<td class="area-select">'.$selectedLabel.'</td>'.
							'<td class="area-arrow">&nbsp;</td>'.
						'</tr>'.
					  '</table>';

			// вставляем элемент в начало массива - строку выбора
			$values = [0 => $firstLabel] + $values;

			$options = '';

			foreach($values AS $k => $v) {

				$options.= Html::a($v, null, [
				
					'data-value' => $k, 
					'onclick' => 'setSelectBox('.self::$fId.', this);'.$onChange
				]);
			}

			$return.= Html::tag('span', $options, ['id' => 'd_sel_'.self::$fId]);
			$return.= Html::hiddenInput($name, $selected, ['id' => 'f_sel_'.self::$fId]);
		}

		$return.= '</div>';

		self::$fId++;

		return $return;
	}

    public static function alertMsg($params = []) {

        $class = ['alert'];
        if (isset($params['class'])) $class[] = $params['class'];

        if (Yii::$app->session->hasFlash('error')) {
            $class[] = 'alert-danger';
            echo Html::tag('div', Yii::$app->session->getFlash('error'), ['class' => implode(' ', $class)]);
            Yii::$app->session->removeFlash('error');
        } elseif (Yii::$app->session->hasFlash('success')) {
            $class[] = 'alert-success';
            echo Html::tag('div', Yii::$app->session->getFlash('success'), ['class' => implode(' ', $class)]);
            Yii::$app->session->removeFlash('success');
        }
    }

    /**
     * формирование поля для алиаса
     * @param ActiveRecord $model
     * @param $field_from
     * @param $field_to
     * @return string
     */
    public static function aliasField(ActiveRecord $model, $field_from, $field_to) {

        $classes = [];
        $classes[] = 'form-group';
        $classes[] = 'field-' . Html::getInputId($model, $field_to);
        if ($model->isAttributeRequired($field_to)) $classes[] = 'required';
        if ($model->hasErrors($field_to)) $classes[] = 'has-error';

        $label = Html::activeLabel($model, $field_to, ['class' => 'control-label']);
        $label_content = Html::tag('div', $label, ['class' => 'col-xs-4 text-right']);

        $input = Html::activeTextInput($model, $field_to, ['class' => 'form-control', 'readonly' => true]);

        $icon = Html::tag('i','',['class' => 'glyphicon glyphicon-refresh']);
        $button = Html::tag('a', $icon, [
            'href' => \yii\helpers\Url::to(['/ajax/alias']),
            'class' => 'input-group-addon btn-alias btn btn-default',
            'title' => 'Получить ' . $model->getAttributeLabel($field_to) . ' из поля ' . $model->getAttributeLabel($field_from),
            'data' => ['from' => Html::getInputId($model, $field_from), 'to' => Html::getInputId($model, $field_to)],
        ]);
        $input_group = Html::tag('div', ($input . $button), ['class' => 'input-group']);
        $input_error = Html::tag('div', implode('<br />', $model->getErrors($field_to)), ['class' => 'help-block']);

        $input_content = Html::tag('div', ($input_group . $input_error), ['class' => 'col-xs-8']);

        return Html::tag('div', ($label_content . $input_content), ['class' => implode(' ', $classes)]);
    }
}