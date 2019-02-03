<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 03.02.2019
 * Time: 21:33
 *  copy from https://github.com/yii2mod/yii2-behaviors/blob/master/PurifyBehavior.php
 */

namespace oboom\comments\behaviors;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\helpers\HtmlPurifier;

class PurifyBehavior extends Behavior
{

    public $attributes = [];

    public $config = null;

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeValidate',
        ];
    }

    public function beforeValidate()
    {
        foreach ($this->attributes as $attribute) {
            $this->owner->$attribute = HtmlPurifier::process($this->owner->$attribute, $this->config);
        }
    }
}