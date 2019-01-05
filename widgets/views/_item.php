<?php
use yii\helpers\Html;

?>
<div class="itemComment <?=$className?>" data-id="<?=$item->id;?>" data-parent="<?=$item->parent;?>">
    <div class="user">
        <?php echo Html::img($item->getAvatar(), ['alt' => $item->getAuthorName()]); ?>
    </div>
    <div class="message">
        <div class="systemCommnet">
            <div class="authorInfo">
                <b><?=$item->getAuthorName();?></b>
                <?=$item->getPostedDate();?>
                <?if($item->created_by == Yii::$app->user->identity->id):?>
                    <i class="icon ion-md-create" data-type="edit" data-id="<?=$item->id;?>"></i>
                <?endif;?>
            </div>
            <div class="like">
                <i class="icon like ion-md-thumbs-up" data-type="true"><span><?=$item->like;?></span></i>
                <i class="icon dislike ion-md-thumbs-down" data-type="false"><span><?=$item->dislike;?></span></i>
            </div>
        </div>
        <?=$item->getContent();?>
    </div>
</div>