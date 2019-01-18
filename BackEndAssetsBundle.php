<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 12.11.2018
 * Time: 13:20
 */

namespace oboom\comments;
use yii\web\AssetBundle;

class BackEndAssetsBundle extends AssetBundle
{
    public $sourcePath = '@vendor/johnproza/yii2-comments/assets';
    public $css = [
        'css/style.css',
        'css/ionicons.min.css'
    ];
    public $js = [
        //'js/script.js',
        //'js/main.bundle.js'
    ];

    public $depends = [
        'yii\web\YiiAsset'
    ];

    public $publishOptions = [
        'forceCopy' => true,
    ];
}