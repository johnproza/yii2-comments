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
    <?php Pjax::begin(['enablePushState' => false, 'timeout' => 20000, 'id' => 'comments']); ?>
    <div class="col-md-12">
        <h2><?=Yii::t('oboom.comments', 'сomments');?></h2>
        <?if (!is_null($items)): ?>
            <?foreach ($items as $item):?>
                <div class="itemComment" data-id="<?=$item->id;?>">
                    <div class="user">
                        <?php echo Html::img($item->getAvatar(), ['alt' => $item->getAuthorName()]); ?>
                    </div>
                    <div class="message">
                        <div class="systemCommnet">
                            <div class="authorInfo">
                                <?=$item->getAuthorName();?>
                                <?=$item->getPostedDate();?>
                            </div>
                            <div class="like">
                                <a href="#">like</a>
                                <a href="#">dislike</a>
                            </div>
                        </div>
                        <?=$item->getContent();?>
                    </div>
                </div>
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
        <?php if (!Yii::$app->user->isGuest) : ?>
            <?php echo $this->render('_form', [
                'model' => $model,
                //'formId' => $formId,
                'encryptedEntity' => $encryptedEntity,
            ]); ?>
        <?php endif; ?>
    </div>
    <?php Pjax::end(); ?>
</div>
