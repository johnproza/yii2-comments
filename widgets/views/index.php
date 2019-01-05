<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 15.11.2018
 * Time: 23:21
 */

use yii\helpers\Url;
use oboom\comments\BaseAssetsBundle;
use yii\data\ActiveDataProvider;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use yii\helpers\Html;

BaseAssetsBundle::register($this);
?>

<div class="row commentsList">
    <?php Pjax::begin(['enablePushState' => false, 'timeout' => 60000, 'id' => 'comments']); ?>
    <div class="col-md-12">
        <h2><?=Yii::t('oboom.comments', 'сomments');?></h2>
        <?if (!is_null($items)): ?>
            <?foreach ($items as $item):?>
                <?=$this->render('_item',['item'=>$item['parent'],'className'=>'parent']);?>
                <?if(count($item['child'])>0) :?>
                    <?foreach ($item['child'] as $child):?>
                        <?=$this->render('_item',['item'=>$child,'className'=>'child']);?>
                    <?endforeach;?>
                <?endif;?>
            <?endforeach;?>
        <?endif;?>
    </div>

<!--    --><?php //echo ListView::widget([
//            'dataProvider' => $items,
//            //'layout' => "{items}\n{pager}",
//            'itemView' => '_item'
//            //'pager' => $pages
////            'viewParams' => [
////                'maxLevel' => 1,
////            ],
////            'options' => [
////                'tag' => 'li',
////                'class' => 'comments-list',
////            ],
////            'itemOptions' => [
////                'tag' => false,
////            ],
//        ]); ?>

    <div class="col-md-12">
        <?php if (Yii::$app->user->isGuest) : ?>
            <p><?=Yii::t('oboom.comments', 'auth');?></p>
        <?php endif; ?>
    </div>

    <div class="col-md-12">
        <?php if (!Yii::$app->user->isGuest) : ?>
            <?php echo $this->render('_form', [
                'model' => $model,
                'encryptedEntity' => $encryptedEntity,
            ]); ?>
        <?php endif; ?>
    </div>
    <?php Pjax::end(); ?>
</div>
