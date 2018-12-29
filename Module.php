<?php

namespace oboom\comments;

use Yii;
use yii\helpers\Inflector;


class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $defaultRoute = 'items';
    public $commentModelClass = 'oboom\comments\models\Comments';
    public $controllerNamespace = 'oboom\comments\controllers';
    public $mainLayout = '@oboom/comments/views/layouts/main.php';

}
