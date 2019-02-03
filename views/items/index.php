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
<div id="app" class="mainSection list">
    <div class="col-md-12">
        <div class="systemBar">

<!--            <div class="col-md-5">-->
<!--                --><?//= Html::dropDownList('cats',$catId, ArrayHelper::map($cats,'id','name'),[
//                        'prompt' => ' -- Выберите категорию --',
//                        'class'=>'form-control',
//                        'id'=>'menuFilter']
//                );?>
<!--            </div>-->
        </div>
    </div>

    <div class="col-md-12">
        <table class="table table-bordered table-hover comment">
            <thead>
            <tr>
                <th class="w50">#</th>
                <th class="w400 left"><?=\Yii::t('oboom.comments', 'tableComment');?></th>
                <th><?=$sort->link('created_at')?></th>
                <th><?=\Yii::t('oboom.comments', 'tableUpdate');?></th>
                <th><?=\Yii::t('oboom.comments', 'tableCreateBy');?></th>
                <th><?=\Yii::t('oboom.comments', 'tableUpdateBy');?></th>
                <th><?=\Yii::t('oboom.comments', 'like');?></th>
                <th><?=\Yii::t('oboom.comments', 'dislike');?></th>
                <th><?=\Yii::t('oboom.comments', 'tableStatus');?></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?foreach ($items as $item) :?>
                <tr data-id="<?=$item-id;?>">
                    <td>
                        <?=$item->id;?>
                    </td>
                    <td class="left">
                        <?=substr($item->content,0,150);?>
                    </td>

                    <td>
                        <?=Yii::$app->formatter->asDatetime($item->created_at, 'yyyy-MM-dd HH:mm');?>
                    </td>
                    <td>
                        <?=Yii::$app->formatter->asDatetime($item->updated_at, 'yyyy-MM-dd HH:mm');?>
                    <td>
                        <?=$item->author->username;?>
                    </td>

                    <td>
                        <?=$item->author->username;?>
                    </td>
                    <td>
                        <?=$item->like;?>
                    </td>
                    <td>
                        <?=$item->dislike;?>
                    </td>
                    <td class="centerItems">
                        <?if($item->status==1):?>
                            <span class="badge badge-success"><?=\Yii::t('oboom.comments', 'activeStatus');?></span>
                        <?elseif($item->status==0) :?>
                            <span class="badge badge-danger"><?=\Yii::t('oboom.comments', 'blockedStatus');?></span>
                        <?endif;?>
                    </td>
                    <td class="center">
                        <?= Html::a('<i class="icon ion-md-create iconBase"></i>', '/comments/items/update?id='.$item['id']) ?>
                        <?= Html::a('<i class="icon ion-md-close-circle-outline iconBase"></i>', '/comments/items/remove?id='.$item['id'],
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
