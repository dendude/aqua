<?php
$rows = Yii::$app->request->get('rows', 10);
?>

<? for ($i = 1; $i <= $rows; $i++): ?>
<table cellpadding="0" cellspacing="0" class="table-padding5" width="100%">
    <tbody>
        <tr>
            <td style="vertical-align:top;text-align:center;width:160px"></td>
            <td style="vertical-align:top;text-align:left">
                <p><strong>Название</strong></p>
                <table class="table-img-characters table-padding5">
                    <tbody>
                        <tr>
                            <th width="30%">Описание</th>
                            <th width="27%">Отделка</th>
                            <th width="15%">Цена</th>
                            <th width="18%">Где находится</th>
                            <th>Столбец</th>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="text-align:center"></td>
                            <td style="text-align:center"></td>
                            <td style="text-align:center"></td>
                            <td style="text-align:center"></td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
    <? if ($i < $rows): ?><hr class="separator-line"/><? endif; ?>
<? endfor; ?>