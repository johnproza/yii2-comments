<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 12.11.2018
 * Time: 12:59
 */

namespace oboom\comments\controllers;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;
use yii\data\ArrayDataProvider;

use oboom\comments\models\Comments;

class ItemsController extends Controller
{
    public function actionIndex($cat=null)
    {
        \yii\helpers\Url::remember();

        $query = Comments::find()->all();
        $provider = new ArrayDataProvider([

            'allModels'=>$query,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'attributes' => [
                    'created_at' =>[
                        'label' => \Yii::t('oboom.comments', 'tableCreate'),
                    ]
                ],
                'defaultOrder' => [ 'created_at'=> SORT_DESC]
            ],
        ]);


        return $this->render('index',[
            'items'=>$provider->getModels(),
            'sort'=>$provider->sort,
            'pages'=>$provider->pagination]);
    }




    public function actionUpdate($id=null)
    {

        $comment = Comments::findOne($id);
        if($comment->load(Yii::$app->request->post()) && $comment->save()) {
            return $this->goBack();
        }
        return $this->render('update', ['item'=>$comment]);

    }

    public function actionRemove($id=null)
    {

        if(Yii::$app->request->isPost && !is_null($id)){
            $cat = MenuItems::findOne($id);
            if ($cat->delete()) {
                return $this->redirect(Yii::$app->request->referrer);
            }
        }
        else {
            return $this->redirect(Yii::$app->request->referrer);
        }
    }

    //ajax update status of publication
    public function actionStatus($json=null)
    {

        if(Yii::$app->request->isAjax){
            $cat = Menu::findOne(Yii::$app->request->post(id));
            if ($cat->status == 0) {
                $cat->status =1;
            }
            else {
                $cat->status =0;
            }
            if ($cat->save()) {
                return $this->asJson([
                    'status' => true,
                ]);
            }
            else {
                return $this->asJson([
                    'status' => false,
                ]);
            }
        }
        else {
            return $this->asJson(['status'=>'Access denied']);
        }
    }

    //ajax update sort
    public function actionSort($json=null)
    {
        if(Yii::$app->request->isAjax){

            $json = Json::decode($json);
            //return Json::encode($json[0]);
            $i=-1;
            foreach ($json[0] as $data){
                ++$i;
                $item = MenuItems::findOne($data['id']);
                $item->sort = $i;
                $item->save();
            }

            return $this->asJson([
                'status' => Json::encode($json[0]),
            ]);
        }
        else {
            return $this->asJson(['status'=>'Access denied']);
        }
    }

    public static function Menu($id){
        return MenuItems::find()->joinWith('seo')->joinWith('menu')->where(['menu_items.status'=>1,'menu.id'=>$id , 'menu.status'=>1])->orderBy(['menu_items.sort'=>SORT_ASC])->asArray()->all();
    }

    protected function getByUrl($url){

        return Seo::find()->joinWith('items')->where(['seo.url'=>$url, 'menu_items.status'=>1])->asArray()->limit(1)->one();
    }
}

