<?
use yii\helpers\Url;
use app\helpers\Normalize;
use app\models\Pages;
use yii\bootstrap\Html;
use \app\models\PhotoAlbums;

$feed = \app\models\News::find()
    ->where(['status' => \app\helpers\Statuses::STATUS_ACTIVE])
    ->orderBy(['ordering' => SORT_ASC, 'id' => SORT_DESC])
    ->limit(5)
    ->all();

if ($type != \app\widgets\MainWidgets::TYPE_ACTIONS) {

    $actions_feed = \app\models\Actions::find()
        ->where(['status' => \app\helpers\Statuses::STATUS_ACTIVE])
        ->orderBy(['ordering' => SORT_ASC, 'id' => SORT_DESC])
        ->limit(2)
        ->all();
}
?>
<div class="main-widgets">

    <? if ($type == \app\widgets\MainWidgets::TYPE_NEWS): ?>

        <div class="widgets widget-sections">
            <span class="widget-title"><?= Yii::$app->vars->val(16) ?></span>
            <ul>
                <li>
                    <a href="<?= Url::to(['/news']) ?>">
                        <? $active = Yii::$app->request->get('section', null) === null ? 'class="active"' : '' ?>
                        <span <?= $active ?>></span>
                        <?= Yii::$app->vars->val(17) ?>
                    </a>
                </li>
            <? foreach ($data AS $data_section): ?>
                <li>
                    <a href="<?= Url::to(['news', 'section' => $data_section->id, 'rating' => !empty($_GET['rating'])]) ?>">
                        <? $active = Yii::$app->request->get('section') == $data_section->id ? 'class="active"' : '' ?>
                        <span <?= $active ?>></span>
                        <?= Html::encode($data_section->name) ?>
                    </a>
                </li>
            <? endforeach; ?>
            </ul>
            <span class="widget-title"><?= Yii::$app->vars->val(23) ?></span>
            <ul>
                <li>
                    <a href="/<?= Yii::$app->request->pathInfo ?>">
                        <? $active = empty($_GET['rating']) ? 'class="active"' : '' ?>
                        <span <?= $active ?>></span><?= Yii::$app->vars->val(24) ?>
                    </a>
                </li>
                <li>
                    <a href="/<?= Yii::$app->request->pathInfo ?>?rating=1">
                        <? $active = !empty($_GET['rating']) ? 'class="active"' : '' ?>
                        <span <?= $active ?>></span><?= Yii::$app->vars->val(25) ?>
                    </a>
                </li>
            </ul>
        </div>

    <? elseif ($type == \app\widgets\MainWidgets::TYPE_RESULTS): ?>

        <div class="widgets widget-sections">
            <span class="widget-title"><?= Yii::$app->vars->val(21) ?></span>
            <ul>
                <li>
                    <a href="<?= Url::to(['/results']) ?>">
                        <?
                        $active = Yii::$app->request->get('section') === null ? 'class="active"' : '';
                        if (strpos(Yii::$app->request->pathInfo, 'result/') === 0) {
                            // если просматриваем результат
                            $active = '';
                        }
                        ?>
                        <span <?= $active ?>></span>
                        <?= Yii::$app->vars->val(22) ?>
                    </a>
                </li>
                <? foreach ($data AS $data_section): ?>
                    <li>
                        <a href="<?= Url::to(['results', 'section' => $data_section->id, 'rating' => !empty($_GET['rating'])]) ?>">
                            <? $active = Yii::$app->request->get('section') == $data_section->id ? 'class="active"' : '' ?>
                            <span <?= $active ?>></span>
                            <?= Html::encode($data_section->name) ?>
                        </a>
                    </li>
                <? endforeach; ?>
            </ul>
            <? if (strpos(Yii::$app->request->pathInfo, 'result/') === false): ?>
            <span class="widget-title"><?= Yii::$app->vars->val(23) ?></span>
            <ul>
                <li>
                    <a href="/<?= Yii::$app->request->pathInfo ?>">
                        <? $active = empty($_GET['rating']) ? 'class="active"' : '' ?>
                        <span <?= $active ?>></span><?= Yii::$app->vars->val(24) ?>
                    </a>
                </li>
                <li>
                    <a href="/<?= Yii::$app->request->pathInfo ?>?rating=1">
                        <? $active = !empty($_GET['rating']) ? 'class="active"' : '' ?>
                        <span <?= $active ?>></span><?= Yii::$app->vars->val(25) ?>
                    </a>
                </li>
            </ul>
            <? endif; ?>
        </div>

    <? elseif ($type == \app\widgets\MainWidgets::TYPE_ACTIONS): ?>

        <div class="widgets widget-sections">
            <span class="widget-title"><?= Yii::$app->vars->val(59) ?></span>
            <ul>
                <li>
                    <a href="<?= Url::to(['/actions']) ?>">
                        <?
                        $active = Yii::$app->request->get('section') === null ? 'class="active"' : '';
                        if (strpos(Yii::$app->request->pathInfo, 'action/') === 0) {
                            // если просматриваем акцию
                            $active = '';
                        }
                        ?>
                        <span <?= $active ?>></span>
                        <?= Yii::$app->vars->val(60) ?>
                    </a>
                </li>
                <? foreach ($data AS $data_section): ?>
                    <li>
                        <a href="<?= Url::to(['actions', 'section' => $data_section->id, 'rating' => !empty($_GET['rating'])]) ?>">
                            <? $active = Yii::$app->request->get('section') == $data_section->id ? 'class="active"' : '' ?>
                            <span <?= $active ?>></span>
                            <?= Html::encode($data_section->name) ?>
                        </a>
                    </li>
                <? endforeach; ?>
            </ul>
            <? if (strpos(Yii::$app->request->pathInfo, 'action/') === false): ?>
            <span class="widget-title"><?= Yii::$app->vars->val(23) ?></span>
            <ul>
                <li>
                    <a href="/<?= Yii::$app->request->pathInfo ?>">
                        <? $active = empty($_GET['rating']) ? 'class="active"' : '' ?>
                        <span <?= $active ?>></span><?= Yii::$app->vars->val(24) ?>
                    </a>
                </li>
                <li>
                    <a href="/<?= Yii::$app->request->pathInfo ?>?rating=1">
                        <? $active = !empty($_GET['rating']) ? 'class="active"' : '' ?>
                        <span <?= $active ?>></span><?= Yii::$app->vars->val(25) ?>
                    </a>
                </li>
            </ul>
            <? endif; ?>
        </div>

    <? elseif ($type == \app\widgets\MainWidgets::TYPE_GALLERY): ?>

        <div class="widgets widget-sections">
            <span class="widget-title"><?= Yii::$app->vars->val(74) ?></span>
            <ul>
                <li>
                    <a href="<?= Url::to([Normalize::fixAlias(Pages::aliasById(PhotoAlbums::PAGE_ID))]) ?>">
                        <?
                        $active = Yii::$app->request->get('id') === null ? 'class="active"' : '';
                        if (strpos(Yii::$app->request->pathInfo, 'album/') === 0) {
                            // если просматриваем альбом
                            $active = '';
                        }
                        ?>
                        <span <?= $active ?>></span>
                        <?= Yii::$app->vars->val(75) ?>
                    </a>
                </li>
                <? foreach ($data AS $data_section): ?>
                    <li>
                        <a href="<?= Url::to([trim(PhotoAlbums::ALIAS_PREFIX, '/'), 'id' => $data_section->id]) ?>">
                            <? $active = Yii::$app->request->get('id') == $data_section->id ? 'class="active"' : '' ?>
                            <span <?= $active ?>></span>
                            <?= Html::encode($data_section->name) ?>
                        </a>
                    </li>
                <? endforeach; ?>
            </ul>
        </div>

    <? else: ?>

        <div class="widgets widget-feed">
            <span class="widget-title"><?= Yii::$app->vars->val(26) ?></span>
            <? if ($feed): ?>
                <ul>
                <? foreach ($feed AS $new_info): ?>
                    <li><?= Html::a($new_info->menu_title, [\app\models\News::ALIAS_PREFIX . $new_info->alias]) ?></li>
                <? endforeach; ?>
                </ul>
            <? endif; ?>
        </div>

    <? endif; ?>

    <div class="widgets widget-informer">
        <!-- Gismeteo Informer (begin) -->
        <div id="GMI_120x90-2_ru" class="gm-info">
            <div style="position:relative;width:120px;height:90px;border:solid 1px;background:#F5F5F5;border-color:#EAEAEA #E4E4E4 #DDDDDD #E6E6E6;border-radius:4px;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;">
                <a style="font:11px/13px Arial,Verdana,sans-serif;text-align:center;text-overflow:ellipsis;text-decoration:none;display:block;overflow:hidden;margin:2px 3px;color:#0678CD;" href="//gismeteo.ru/weather-zlatibor-66783/">Златибор</a>
                <a style="font:9px/11px Tahoma,Arial,sans-serif;letter-spacing:0.5px;text-align:center;text-decoration:none;position:absolute;bottom:3px;left:0;width:100%;color:#333;" href="//gismeteo.ru"><span style="color:#0099FF;">Gis</span>meteo</a>
            </div>
        </div>
        <script type="text/javascript">
            (function() {
                var
                    d = this.document,
                    o = this.navigator.userAgent.match(/MSIE (6|7|8)/) ? true : false,
                    s = d.createElement('script');

                s.src  = '//www.gismeteo.ru/informers/simple/install/';
                s.type = 'text/javascript';
                s[(o ? 'defer' : 'async')] = true;
                s[(o ? 'onreadystatechange' : 'onload')] = function() {
                    try {new GmI({
                        slug : '5f320b753042ca1332b7c6a3e232e64a',
                        type : '120x90-2',
                        city : '66783',
                        lang : 'ru'
                    })} catch (e) {}
                }

                d.body.appendChild(s);
            })();
        </script>
        <!-- Gismeteo Informer (finish) -->
    </div>

    <? if ($type != \app\widgets\MainWidgets::TYPE_ACTIONS && $actions_feed): ?>

    <div class="widgets widget-feed">
        <span class="widget-title"><?= Yii::$app->vars->val(27) ?></span>
        <div class="actions-feed">
            <? foreach ($actions_feed AS $action_info): ?>
                <a class="action-feed-item" href="<?= Url::to([\app\models\Actions::ALIAS_PREFIX . $action_info->alias]) ?>" title="Перейти к акции: <?= Html::encode($action_info->menu_title) ?>">
                    <span class="action-feed-photo">
                        <?= Html::img($action_info->getFirstImage(), ['alt' => $action_info->title]) ?>
                    </span>
                    <span class="action-feed-title"><?= Html::encode($action_info->menu_title) ?></span>
                </a>
            <? endforeach; ?>
        </div>
    </div>

    <? endif; ?>

</div>