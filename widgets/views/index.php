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
    <div class="col-md-12">
        <h2><?=Yii::t('oboom.comments', 'сomments');?></h2>

        <?if (!is_null($top)): ?>
            <div class="topComment">
                <?if( $top['parent']->id != $top['top']->id) :?>
                    <div class="parent" data-id="<?=$top['parent']->id;?>">
                        <?=$this->render('_item',['item'=>$top['parent'],'className'=>'parent']);?>
                        <div class="children best">
                            <?=$this->render('_item',['item'=>$top['top'],'className'=>'child']);?>
                        </div>
                    </div>
                <?else:?>
                    <div class="parent best" data-id="<?=$item['parent']->id;?>">
                        <?=$this->render('_item',['item'=>$item['parent'],'className'=>'parent']);?>
                        <i class="icon dislike ion-md-thumbs-down" data-type="false"></i>
                    </div>
                <?endif;?>
            </div>
        <?endif;?>


        <?if (!is_null($items)): ?>
            <?foreach ($items as $item):?>
                <?if(count($item['child'])>0) :?>
                    <div class="parent" data-id="<?=$item['parent']->id;?>">
                        <?=$this->render('_item',['item'=>$item['parent'],'className'=>'parent']);?>
                        <div class="children">
                            <?foreach ($item['child'] as $child):?>
                                <?=$this->render('_item',['item'=>$child,'className'=>'child']);?>
                            <?endforeach;?>
                        </div>
                    </div>
                <?else:?>
                    <div class="parent" data-id="<?=$item['parent']->id;?>">
                        <?=$this->render('_item',['item'=>$item['parent'],'className'=>'parent']);?>
                    </div>
                <?endif;?>
            <?endforeach;?>
        <?endif;?>

        <div id="allComments" data-entity="<?=$encryptedEntity?>"></div>
        <div id="topComments" data-id="<?=$encryptedEntity;?>"></div>
    </div>



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
</div>
