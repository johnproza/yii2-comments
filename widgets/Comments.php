<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 15.11.2018
 * Time: 23:07
 */

namespace oboom\comments\widgets;
use yii\base\Widget;
use yii\helpers\Html;

class Comments extends Widget
{
    /*
     *      $template -> path to your template | default 'menu' | yii2-menu/widgets/views/menu.php
     *      $data -> values from DataBase
     *      $type -> base css style type of menu (horizontal-menu | vertical-menu)
     *      $menuId -> id value menu table from DataBase (table 'menu')
     *      $className -> personal user css styles for customize menu
     */
    public $model = null;
    public $relatedTo = null;
    public $entity = null;
    public $entityId = null;
//    public $className;
//    public $type="horizontal-menu";
//    public $menuId;

    public function init(){
        parent::init();
        if ($this->model!=null && $this->relatedTo!=null){
            $this->entity = hash('crc32', get_class($this->model));
            $this->entityId = $this->model->id;
            var_dump($this->entity,$this->entityId);
        }
        else {

            throw new \ErrorException('menuId is required attribute');
        }
    }

    public function run(){
        //var_dump(hash('crc32', get_class($this->model)));
//        if ($this->menuId!='' && $this->menuId!==null){
//            return $this->render($this->template,
//                    ['type'=>$this->type,
//                     'className'=>$this->className?' '.$this->className:'',
//                     'data'=>$this->data]);
//        }

    }

}