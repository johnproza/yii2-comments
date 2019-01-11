<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 15.11.2018
 * Time: 23:07
 */

namespace oboom\comments\widgets;
use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;


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
    public $params = [
        'view'=>null,
        'template' => 'index',
        'showTop' => true,
        'limit'=>10,
    ];

    protected $encryptedEntity = null;



    public function init(){
        parent::init();
        if ($this->model!=null && $this->relatedTo!=null){
            $this->entity = hash('crc32', get_class($this->model));
            $this->entityId = $this->model->id;
            $this->encryptedEntity = $this->encrypted();

            //var_dump($this->encryptedEntity);
        }
        else {

            throw new \ErrorException('menuId is required attribute');
        }
    }



    public function run(){
        $commentClass = Yii::$app->getModule('comments')->commentModelClass;
        $commentModel = Yii::createObject([
            'class' => $commentClass,
            'entity' => $this->entity,
            'entityId' => $this->entityId,
        ]);

        $this->getCommentDataProvider(null);

         return $this->render($this->params['template'],
                    ['encryptedEntity'=>$this->encryptedEntity,
                     'model'=>$commentModel,
                     'items'=>$this->getCommentDataProvider(\oboom\comments\models\Comments::className()),
                     'top'=>$this->params['showTop'] ? $this->getTopComments(\oboom\comments\models\Comments::className()) : null
                    ]);
        }

    public function encrypted() {
        $data = Json::encode([
            'entity' => $this->entity,
            'entityId' => $this->entityId,
            'relatedTo' => $this->relatedTo,
        ]);
        $key = Yii::$app->getModule('comments')->id;
        return base64_encode(Yii::$app->security->encryptByKey($data,$key)); //Yii::$app->getModule('')->id
    }

    protected function getCommentDataProvider($commentClass=null)
    {
        return \oboom\comments\models\Comments::getTree($this->entity,$this->entityId,0,$this->params['limit']);
    }

    protected function getTopComments($commentClass=null)
    {
        return \oboom\comments\models\Comments::getTop($this->entity,$this->entityId);
    }
}