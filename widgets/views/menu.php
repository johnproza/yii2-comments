<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 15.11.2018
 * Time: 23:21
 */

use yii\helpers\Url;
use oboom\menu\FrontAssetsBundle;

FrontAssetsBundle::register($this);
?>
<?if (!empty($data)):?>
<nav class="nav <?=$type;?><?=$className;?>">
    <ul>
    <?foreach ($data as $item):?>
       <li>
           <a href="<?
                    if(!empty($item['redirect']) && !is_null($item['redirect'])) {
                        echo Url::toRoute($item['redirect']);
                    }
                    else {
                        echo Url::toRoute('/'.$item['seo']['url']);
                    }
                      ;?>"><?=$item['label'];?></a>
       </li>
    <?endforeach;?>
    </ul>
</nav>
<?endif;?>
