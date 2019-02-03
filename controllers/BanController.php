<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 12.11.2018
 * Time: 12:59
 */

namespace oboom\comments\controllers;
use oboom\comments\models\CommentsBan;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;
use yii\data\ArrayDataProvider;

use oboom\comments\models\Comments;
use yii\web\User;

class BanController extends Controller
{
    public function actionIndex($cat=null)
    {
        \yii\helpers\Url::remember();

        $query = CommentsBan::find()->all();
        $provider = new ArrayDataProvider([

            'allModels'=>$query,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'attributes' => [
                    'expires' =>[
                        'label' => \Yii::t('oboom.comments', 'expires'),
                    ]
                ],
                'defaultOrder' => [ 'expires'=> SORT_DESC]
            ],
        ]);


        return $this->render('index',[
            'items'=>$provider->getModels(),
            'sort'=>$provider->sort,
            'pages'=>$provider->pagination]);
    }




    public function actionCreate($id=null)
    {

        $ban = new CommentsBan();
        $user = Yii::$app->getUser()->identity;


        if($ban->load(Yii::$app->request->post()) && $ban->save()) {
            return $this->goBack();
        }
        return $this->render('create', ['item'=>$ban, 'users'=>$user::find()->all()]);

    }

    public function actionUpdate($id=null)
    {
        $user = Yii::$app->getUser()->identity;

        $ban = CommentsBan::findOne($id);
        if($ban->load(Yii::$app->request->post()) && $ban->save()) {
            return $this->goBack();
        }
        return $this->render('update', ['item'=>$ban, 'users'=>$user::find()->all()]);

    }

    public function actionRemove($id=null)
    {

        if(Yii::$app->request->isPost && !is_null($id)){
            $ban = CommentsBan::findOne($id);
            if ($ban->delete()) {
                return $this->redirect(Yii::$app->request->referrer);
            }
        }
        else {
            return $this->redirect(Yii::$app->request->referrer);
        }
    }


}

