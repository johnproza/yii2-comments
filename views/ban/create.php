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
use oboom\comments\BackEndAssetsBundle;
use kartik\select2\Select2;
$this->title = \Yii::t('oboom.comments', 'title');
BackEndAssetsBundle::register($this);
?>
<div id="app" class="mainSection row">
    <div class="col-md-12">
        <?php $form = ActiveForm::begin(['id' => 'form-gallery',
            'options' => ['class' => 'form']]); ?>
        <div class="row form-group bg">


            <div class="col-lg-12 col-md-12">
                <?= $form->field($item, "user_id")->widget(Select2::classname(), [
                    'data' => ArrayHelper::map($users,'id','username'),
                    'options' => ['placeholder' => Yii::t('oboom.comments', 'user_id')],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ])->label(false);
                ?>
            </div>
            <div class="col-lg-6 col-md-6">
                <?= $form->field($item, 'reason')->textarea(['autofocus' => true, 'placeholder'=>Yii::t('oboom.comments', 'reason')])->label(false) ?>
            </div>
            <div class="col-lg-6 col-md-6">
                <input type="date" id="expires" class="form-control" placeholder="<?=Yii::t('oboom.comments', 'expires')?>"/>
            </div>
            <div class="col-lg-6 col-md-6">
                <?= $form->field($item, 'expires')->input('hidden',['class'=>'form-control'])->label(false); ?>
            </div>



        </div>
        <div class="form-group">
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            <?= Html::a('Отмена', Yii::$app->request->referrer, ['class'=>'btn btn-danger']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>


</div>
