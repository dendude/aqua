<?php

use app\modules\admin\controllers\MenuController;
use yii\helpers\Html;
use \app\models\Menu;
use \yii\helpers\Url;

$action = MenuController::LIST_NAME;
$this->title = $action;
$this->params['breadcrumbs'] = [
    ['label' => $action]
];

$menu = Menu::find()->root()->orderBy('ordering ASC')->all();

echo '<div class="clearfix"></div>';
// вывод сообщений если имеются
\app\helpers\MHtml::alertMsg();

echo '<ul class="manage-menu">';

foreach ($menu AS $menu_item) {
    // первый уровень
    echo '<li>';

        echo '<span class="menu-item">';
            echo '<a class="btn btn-default btn-xs btn-act-up" href="' . Url::to(['up', 'id' => $menu_item->id]) . '" title="Переместить вверх"><i class="glyphicon glyphicon-chevron-up"></i></a>';
            echo '<a class="btn btn-default btn-xs btn-act-down" href="' . Url::to(['down', 'id' => $menu_item->id]) . '" title="Переместить вниз"><i class="glyphicon glyphicon-chevron-down"></i></a>';

            echo '<a class="btn btn-default btn-xs" title="Скрыть" href="' . Url::to(['hide', 'id' => $menu_item->id]) . '"><i class="glyphicon glyphicon-eye-close"></i></a>';
            echo '<a class="btn btn-default btn-xs" title="Опубликовать" href="' . Url::to(['show', 'id' => $menu_item->id]) . '"><i class="glyphicon glyphicon-eye-open"></i></a>';

            echo '<a class="btn btn-info btn-xs btn-act" title="Редактировать" href="' . Url::to(['edit', 'id' => $menu_item->id]) . '"><i class="glyphicon glyphicon-pencil"></i></a>';

            echo Html::a('<i class="glyphicon glyphicon-plus"></i>', ['add', 'id' => $menu_item->id], ['class' => 'btn btn-success btn-xs btn-act',
                                                                                                           'title' => 'Добавить подпункт меню "' . $menu_item->menu_name . '"']);

            echo Html::tag('span', $menu_item->menu_name, ['class' => 'active-' . $menu_item->status]);
        echo '</span>';

        $childs = Menu::find()->where(['parent_id' => $menu_item->id])->orderBy('ordering ASC')->all();
        if ($childs) {
            // второй уровень
            echo '<ul>';
            foreach ($childs AS $child_item) {

                echo '<li>';

                    echo '<span class="menu-item">';
                        echo '<a class="btn btn-danger btn-xs btn-act" href="' . Url::to(['delete', 'id' => $child_item->id]) . '" title="Удалить"><i class="glyphicon glyphicon-trash"></i></a>';

                        echo '<a class="btn btn-default btn-xs btn-act-up" href="' . Url::to(['up', 'id' => $child_item->id]) . '" title="Переместить вверх"><i class="glyphicon glyphicon-chevron-up"></i></a>';
                        echo '<a class="btn btn-default btn-xs btn-act-down" href="' . Url::to(['down', 'id' => $child_item->id]) . '" title="Переместить вниз"><i class="glyphicon glyphicon-chevron-down"></i></a>';

                        echo '<a class="btn btn-default btn-xs" title="Скрыть" href="' . Url::to(['hide', 'id' => $child_item->id]) . '"><i class="glyphicon glyphicon-eye-close"></i></a>';
                        echo '<a class="btn btn-default btn-xs" title="Опубликовать" href="' . Url::to(['show', 'id' => $child_item->id]) . '"><i class="glyphicon glyphicon-eye-open"></i></a>';

                        echo '<a class="btn btn-info btn-xs btn-act" title="Редактировать" href="' . Url::to(['edit', 'id' => $child_item->id]) . '"><i class="glyphicon glyphicon-pencil"></i></a>';

                        echo Html::a('<i class="glyphicon glyphicon-plus"></i>', ['add', 'id' => $child_item->id], ['class' => 'btn btn-success btn-xs btn-act',
                                                                                                                    'title' => 'Добавить подпункт меню "' . $child_item->menu_name . '"']);

                        echo Html::tag('span', $child_item->menu_name, ['class' => 'active-' . $child_item->status]);
                        if ($child_item->page_id) {
                            echo '&nbsp;&nbsp;' . Html::tag('i','',['class' => 'text-muted glyphicon glyphicon-ok', 'title' => 'Прикреплена страница']);
                        }
                    echo '</span>';

                $subchilds = Menu::find()->where(['parent_id' => $child_item->id])->orderBy('ordering ASC')->all();
                if ($subchilds) {
                    // третий уровень
                    echo '<ul>';
                    foreach ($subchilds AS $subchild_item) {

                        echo '<li>';

                            echo '<span class="menu-item">';
                                echo '<a class="btn btn-danger btn-xs btn-act" href="' . Url::to(['delete', 'id' => $subchild_item->id]) . '" title="Удалить"><i class="glyphicon glyphicon-trash"></i></a>';

                                echo '<a class="btn btn-default btn-xs btn-act-up" href="' . Url::to(['up', 'id' => $subchild_item->id]) . '" title="Переместить вверх"><i class="glyphicon glyphicon-chevron-up"></i></a>';
                                echo '<a class="btn btn-default btn-xs btn-act-down" href="' . Url::to(['down', 'id' => $subchild_item->id]) . '" title="Переместить вниз"><i class="glyphicon glyphicon-chevron-down"></i></a>';

                                echo '<a class="btn btn-default btn-xs" title="Скрыть" href="' . Url::to(['hide', 'id' => $subchild_item->id]) . '"><i class="glyphicon glyphicon-eye-close"></i></a>';
                                echo '<a class="btn btn-default btn-xs" title="Опубликовать" href="' . Url::to(['show', 'id' => $subchild_item->id]) . '"><i class="glyphicon glyphicon-eye-open"></i></a>';

                                echo '<a class="btn btn-info btn-xs btn-act" title="Редактировать" href="' . Url::to(['edit', 'id' => $subchild_item->id]) . '"><i class="glyphicon glyphicon-pencil"></i></a>';

                                echo Html::tag('span', $subchild_item->menu_name, ['class' => 'active-' . $subchild_item->status]);
                                if ($subchild_item->page_id) {
                                    echo '&nbsp;&nbsp;' . Html::tag('i','',['class' => 'text-muted glyphicon glyphicon-ok', 'title' => 'Прикреплена страница']);
                                }
                            echo '</span>';

                        echo '</li>';
                    }
                    echo '</ul>';
                }

                echo '</li>';
            }
            echo '</ul>';
        }

    echo '</li>';
}

echo '</ul>';

$this->registerJs("
$(document).on('click', '.menu-item a', function(e){
    var \$this = $(this);

    if (\$this.hasClass('btn-act')) {
        // just url
    } else {
        e.preventDefault();
        $.ajax({
            url: \$this.attr('href'),
            dataType: 'html',
            success: function(result) {
                $('.admin-content').html(result);
            }
        });
    }
});
");