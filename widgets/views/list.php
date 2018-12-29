<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 15.11.2018
 * Time: 23:21
 */

use yii\helpers\Url;
//use oboom\menu\FrontAssetsBundle;

//FrontAssetsBundle::register($this);
?>

<div class="row">
    <div class="col-md-12">
        <?if (!is_null($items)): ?>
            <?foreach ($items as $item):?>
                <p><?=$item->content;?></p>
                <p><?=$item->created_by;?></p>
            <?endforeach;?>
        <?endif;?>
    </div>

    <div class="col-md-12">
        <?php if (!Yii::$app->user->isGuest) : ?>
            <?php echo $this->render('_form', [
                'model' => $model,
                //'formId' => $formId,
                'encryptedEntity' => $encryptedEntity,
            ]); ?>
        <?php endif; ?>
    </div>
</div>
