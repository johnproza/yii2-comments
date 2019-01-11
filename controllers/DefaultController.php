<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 12.11.2018
 * Time: 12:59
 */

namespace oboom\comments\controllers;
use Yii;
use yii\web\Controller;
use yii\helpers\Json;
use yii\filters\VerbFilter;
use yii\filters\ContentNegotiator;
use oboom\comments\models\Comments;
use oboom\comments\events\CommentEvent;
use yii\widgets\ActiveForm;

class DefaultController extends Controller
{

    public function behaviors()
    {
        return [

            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'create' => ['post'],
                    'delete' => ['post', 'delete'],
                ],
            ],
//            'contentNegotiator' => [
//                'class' => ContentNegotiator::class,
//                'only' => ['create'],
//                'formats' => [
//                    'application/json' => Response::FORMAT_JSON,
//                ],
//            ],
        ];
    }

    public function actionСreate($entity)
    {
        var_dump($entity);
    }

    public function actionTest($entity)
    {
        if(Yii::$app->request->isPost && !Yii::$app->user->getIsGuest()){
            $model = new Comments();
            //var_dump($this->getCommentAttributesFromEntity($entity));
            $model->setAttributes($this->getCommentAttributesFromEntity($entity));
            $model->created_by = Yii::$app->user->identity->getId();
            $model->updated_by = Yii::$app->user->identity->getId();
            //var_dump(Yii::$app->request->getIsAjax());
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                //$this->trigger(self::EVENT_AFTER_CREATE, $event);
                return $this->asJson(['status' => 'success']);

            }
            else {
                return $this->asJson([
                    'status' => 'error',
                    'errors' => ActiveForm::validate($model),
                    //'sss' => Yii::$app->request->,
                ]);
            }
        }

        else {
            return false;
        }

//        $model = new Comments();
//        $model->setAttributes($this->getCommentAttributesFromEntity($entity));
//        //$event = Yii::createObject(['class' => CommentEvent::class, 'commentModel' => $model]);
//        $model->created_by = Yii::$app->user->identity->getId();
//        $model->updated_by = Yii::$app->user->identity->getId();
//        //var_dump($entity, $this->getCommentAttributesFromEntity($entity));
//        //var_dump($model->save(false));
//        $this->trigger(self::EVENT_BEFORE_CREATE, $event);
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            //$this->trigger(self::EVENT_AFTER_CREATE, $event);
//            return $this->asJson(['status' => 'success']);
//
//        }
//
//
//        return $this->asJson([
//            'status' => 'error',
//            'errors' => ActiveForm::validate($model),
//        ]);



    }

    public function actionGetTop($entity){
        if(Yii::$app->request->isGet && !Yii::$app->user->getIsGuest()){
            $dataEntity = Json::decode($this->getCommentAttributesFromEntity($entity));
            $data = Comments::getTop($dataEntity['entity'],$dataEntity['entityId'],$dataEntity['relatedTo']);
            //Comments::getTop('ddd');
            //var_dump(Json::decode($dataEntity));
            return $this->asJson([
                'parent' => $data['parent'],
                'top' => $data['top'],
            ]);
        }
    }

    public function actionGetAll($entity){
        if(Yii::$app->request->isGet && !Yii::$app->user->getIsGuest()){
            $dataEntity = Json::decode($this->getCommentAttributesFromEntity($entity));
            $data = Comments::getTree($dataEntity['entity'],$dataEntity['entityId'],$dataEntity['relatedTo']);
            //Comments::getTop('ddd');
            //var_dump(Json::decode($dataEntity));
            return $this->asJson([
                'data' => $data
            ]);
        }
    }

    protected function getCommentAttributesFromEntity($entity)
    {
        return $decryptEntity = Yii::$app->getSecurity()->decryptByKey(base64_decode($entity), Yii::$app->getModule('comments')->id);
        if (false !== $decryptEntity) {
            return Json::decode($decryptEntity);
        }
        throw new BadRequestHttpException(Yii::t('yii2mod.comments', 'Oops, something went wrong. Please try again later.'));
    }

}

