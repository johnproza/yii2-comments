<?php

namespace oboom\comments;

use Yii;
use yii\helpers\Inflector;


class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $defaultRoute = 'default';
    public $controllerNamespace = 'oboom\comments\controllers';

    public $mainLayout = '@oboom/comments/views/layouts/main.php';

}
