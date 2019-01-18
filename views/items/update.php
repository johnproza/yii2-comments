<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 27.12.2018
 * Time: 19:32
 */
use yii\helpers\Html;
use yii\bootstrap4\ActiveForm;
use yii\helpers\ArrayHelper;
use oboom\comments\BaseAssetsBundle;
use yii\widgets\LinkPager;
$this->title = \Yii::t('oboom.comments', 'title');
BaseAssetsBundle::register($this);
?>
<div id="app" class="mainSection list">
    <div class="col-md-12">
        <div class="systemBar">
            <div>
                <?=Yii::t('oboom.comments', 'created_by');?> &mdash; <?=$item->author->username?>
                (<?=Yii::$app->formatter->asDatetime($item->created_at,'yyyy-MM-dd HH:mm');?>)
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <?php $form = ActiveForm::begin(['id' => 'form-comment',
            'options' => ['class' => 'form']]); ?>
        <div class="row form-group">


            <div class="col-lg-12 col-md-12">
                <?= $form->field($item, 'content')->textArea(['placeholder'=>'Описание'])->label(false) ?>
            </div>
            <div class="col-lg-6 col-md-6">
                <?= $form->field($item, 'like')->textInput(['autofocus' => true,'placeholder'=>'Название меню'])->label(true) ?>
            </div>
            <div class="col-lg-6 col-md-6">
                <?= $form->field($item, 'dislike')->textInput(['placeholder'=>'Редирект url'])->label(true) ?>
            </div>
<!--            <div class="col-lg-6 col-md-6">-->
<!--                --><?//= $form->field($item, 'parent')->dropDownList($arrayParent,
//                    ['prompt' => ' -- Выберите родителя --'])->label(false) ?>
<!--            </div>-->
<!--            <div class="col-lg-6 col-md-6">-->
<!--                --><?//= $form->field($item, 'menu_id')->dropDownList($arrayMenu,
//                    ['prompt' => ' -- Выберите меню --'])->label(false)?>
<!--            </div>-->
            <div class="col-lg-12 col-md-12">
                <?= $form->field($item, 'status')->radioList([
                        1 => 'Опубликовано',
                        0 => 'Не опубликовано'])
                    ->label('Статус')?>
            </div>
        </div>
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            <?= Html::a('Отмена', Yii::$app->request->referrer, ['class'=>'btn btn-danger']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>


</div>
