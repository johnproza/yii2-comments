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
use yii\data\ArrayDataProvider;
use yii\helpers\Json;
use oboom\comments\models\Comments;
use yii\widgets\ActiveForm;

class DefaultController extends Controller
{
    public function actionСreate($entity)
    {
        var_dump($entity);
    }

    public function actionTest($entity)
    {
        $model = new Comments();
        $model->setAttributes($this->getCommentAttributesFromEntity($entity));
        $model->created_by = Yii::$app->user->identity->getId();
        $model->updated_by = Yii::$app->user->identity->getId();
        //var_dump($entity, $this->getCommentAttributesFromEntity($entity));
        //var_dump($model->save(false));
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //$this->trigger(self::EVENT_AFTER_CREATE, $event);
            return ['status' => 'success'];
        }



        var_dump(ActiveForm::validate($model));



    }


    protected function getCommentAttributesFromEntity($entity)
    {
        $decryptEntity = Yii::$app->getSecurity()->decryptByKey(utf8_decode($entity), Yii::$app->getModule('comments')->id);
        if (false !== $decryptEntity) {
            return Json::decode($decryptEntity);
        }
        throw new BadRequestHttpException(Yii::t('yii2mod.comments', 'Oops, something went wrong. Please try again later.'));
    }

}

