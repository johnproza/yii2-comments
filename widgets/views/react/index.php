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
        <div id="allComments" data-entity="<?=$encryptedEntity?>"></div>
        <div id="topComments" data-id="<?=$encryptedEntity;?>"></div>
    </div>



<!--    <div class="col-md-12">-->
<!--        --><?php //if (Yii::$app->user->isGuest) : ?>
<!--            <p>--><?//=Yii::t('oboom.comments', 'auth');?><!--</p>-->
<!--        --><?php //endif; ?>
<!--    </div>-->
<!---->
<!--    <div class="col-md-12">-->
<!--        --><?php //if (!Yii::$app->user->isGuest) : ?>
<!--            --><?php //echo $this->render('_form', [
//                'model' => $model,
//                'encryptedEntity' => $encryptedEntity,
//            ]); ?>
<!--        --><?php //endif; ?>
<!--    </div>-->
</div>
