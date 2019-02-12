<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 27.12.2018
 * Time: 19:32
 */
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use oboom\comments\BackEndAssetsBundle;
use yii\widgets\LinkPager;
$this->title = \Yii::t('oboom.comments', 'title');
BackEndAssetsBundle::register($this);

?>
<div id="app" class="mainSection row">
    <div class="col-md-12">
        <div class="systemBar">
            <?= Html::a("Создать запись", '/comments/ban/create', ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <div class="col-md-12">
        <table class="table table-bordered table-hover comment">
            <thead>
            <tr>
                <th class="w50">#</th>
                <th class="w50 "><?=\Yii::t('oboom.comments', 'user_id');?></th>
                <th><?=\Yii::t('oboom.comments', 'reason');?></th>
                <th><?=$sort->link('expires')?></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?foreach ($items as $item) :?>
                <tr data-id="<?=$item-id;?>">
                    <td>
                        <?=$item->id;?>
                    </td>
                    <td>
                        <?=$item->user->username;?>
                    </td>
                    <td>
                        <?=$item->reason;?>
                    </td>

                    <td>
                        <?=Yii::$app->formatter->asDatetime($item->expires, 'yyyy-MM-dd HH:mm');?>
                    </td>

                    <td class="center">
                        <?= Html::a('<i class="icon ion-md-create iconBase"></i>', '/comments/ban/update?id='.$item['id']) ?>
                        <?= Html::a('<i class="icon ion-md-close-circle-outline iconBase"></i>', '/comments/ban/remove?id='.$item['id'],
                            ['data-confirm' => \Yii::t('oboom.comments', 'remove'),
                                'data-method' => 'post',
                                'data-pjax' => '0',]
                        ) ?>
                    </td>
                </tr>

            <?endforeach;?>

            </tbody>
        </table>

        <?php
        echo LinkPager::widget([
            'pagination' => $pages,
        ]);
        ?>
    </div>


</div>
