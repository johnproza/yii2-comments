<?php
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>
<div class="comment-form-container">
    <?php $form = ActiveForm::begin([
        'options' => [
            'id' => 'gallery-form',
            'class' => 'gallery-box',
        ],
        'action' => Url::to(['/comments/default/test', 'entity' => $encryptedEntity]),
        'validateOnChange' => false,
        'validateOnBlur' => false,
    ]); ?>

    <?php echo $form->field($model, 'content')->textarea(['placeholder' => Yii::t('oboom.comments', 'add a gallery...'), 'rows' => 4, 'data' => ['comments' => 'content']]); ?>
    <?php// echo $form->field($model, 'parentId', ['template' => '{input}'])->hiddenInput(['data' => ['gallery' => 'parent-id']]); ?>
    <div class="comment-box-partial">
<!--        <div class="button-container show">-->
<!--            --><?php //echo Html::a(Yii::t('yii2mod.comments', 'Click here to cancel reply.'), '#', ['id' => 'cancel-reply', 'class' => 'pull-right', 'data' => ['action' => 'cancel-reply']]); ?>
            <?php echo Html::submitButton(Yii::t('oboom.comments', 'gallery'), ['class' => 'btn btn-primary gallery-submit']); ?>
<!--        </div>-->
    </div>
    <?php $form->end(); ?>
</div>