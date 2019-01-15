<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 12.11.2018
 * Time: 12:59
 */

namespace oboom\comments\controllers;
use oboom\comments\models\CommentsVote;
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

    public function actionCreate()
    {
        if(Yii::$app->request->isPost && !Yii::$app->user->getIsGuest()){
            $model = new Comments();
            $post=$model->load(Yii::$app->request->post(), '');
            $model->setAttributes(Json::decode($this->getCommentAttributesFromEntity(Yii::$app->request->post('entity'))));
            $model->created_by = Yii::$app->user->identity->getId();
            $model->parent = Yii::$app->request->post('parent');
            $model->content = Yii::$app->request->post('content');
            $model->updated_by = Yii::$app->user->identity->getId();

            if ($post && $model->save()) {
                return $this->asJson([
                    'status' => true,
                    'message' => Yii::t('oboom.comments', 'commentAdd')
                ]);
            }
        }


        return $this->asJson([
            'status' => false,
            'message' => Yii::t('oboom.comments', 'commentNotAdd')
        ]);


    }

    public function actionTest($entity)
    {
        if(Yii::$app->request->isPost && !Yii::$app->user->getIsGuest()){
            $model = new Comments();
            //var_dump($this->getCommentAttributesFromEntity($entity));
            $model->setAttributes(Json::decode($this->getCommentAttributesFromEntity($entity)));
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

    //react

    public function actionGetTop($entity){
        $data = $this->actionGetTopData($entity);
        if($data){
            return $this->asJson([
                'status' => true,
                'parent' => $data['parent'],
                'top' => $data['top'],
            ]);
        }

        else {
            return $this->asJson([
                'status' => false,
                'message' => Yii::t('oboom.comments', 'dataError')
            ]);
        }


    }

    public function actionGetPreview($entity){
        $data = $this->actionGetTop10($entity,10);
        if($data){
            return $this->asJson([
                'status' => true,
                'data' => $data
            ]);
        }

        else {
            return $this->asJson([
                'status' => false,
                'message' => Yii::t('oboom.comments', 'dataError')
            ]);
        }


    }

    protected function actionGetTopData($entity){
        if(Yii::$app->request->isGet){
            $dataEntity = Json::decode($this->getCommentAttributesFromEntity($entity));
            $data = Comments::getTop($dataEntity['entity'],$dataEntity['entityId'],$dataEntity['relatedTo']);

            return $data ? $data : false ;
        }
    }

    protected function actionGetTop10($entity,$limit=10){
        if(Yii::$app->request->isGet){
            $dataEntity = Json::decode($this->getCommentAttributesFromEntity($entity));
            $data = Comments::getTree($dataEntity['entity'],$dataEntity['entityId'],$dataEntity['relatedTo'], $limit);

            return $data ? $data : false ;
        }
    }

    public function actionCan(){
        if(!Yii::$app->user->getIsGuest()){
            return $this->asJson([
                'can' => true
            ]);
        }

        else {
            return $this->asJson([
                'can' => false
            ]);
        }
    }

    public function actionVote($id=null,$like=null,$dislike=null){
        if(!Yii::$app->user->getIsGuest() && Yii::$app->request->isGet){

            if(!empty($like) && $this->setCheckVote(1,$id)){
                return $this->setVote(1,$id,$like);
            }

            elseif (!empty($dislike) && $this->setCheckVote(0,$id)) {
                return $this->setVote(0,$id,$dislike);
            }

            return $this->asJson([
                'status'=> false,
                'like'=>$like,
                'dislike'=>$dislike,
                'model1' =>CommentsVote::findOne(['comments_id'=>$id,'user'=>Yii::$app->user->getId(),'vote_type'=>1]),
                'model0' =>CommentsVote::findOne(['comments_id'=>$id,'user'=>Yii::$app->user->getId(),'vote_type'=>0]),
                'message' => Yii::t('oboom.comments', 'voteLikeNotAdd')
            ]);

        }

        return $this->asJson([
            'status'=> false,
            'message' => Yii::t('oboom.comments', 'voteLikeNotAdd')
        ]);
    }

    public function actionGetAll($entity){
        if(Yii::$app->request->isGet){
            $dataEntity = Json::decode($this->getCommentAttributesFromEntity($entity));
            $data = Comments::getTree($dataEntity['entity'],$dataEntity['entityId'],$dataEntity['relatedTo']);
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



    protected function setCheckVote($type=0,$commentId=null){
        return CommentsVote::findOne([  'comments_id'=>$commentId,
                                        'user'=>Yii::$app->user->getId(),
                                        'vote_type'=>$type]) ? false : true;
    }

    protected function setVote($type=0,$commentId=null,$count){
        $comment = Comments::findOne(['id'=>$commentId]);
        $commentVote = new CommentsVote();
        if($type==1){
            $comment->like =  $count;
            $commentVote->user = Yii::$app->user->getId();
            $commentVote->vote_type = $type;
            $commentVote->comments_id = $commentId;
        }
        elseif($type==0) {
            $comment->dislike =  $count;
            $commentVote->user = Yii::$app->user->getId();
            $commentVote->vote_type = $type;
            $commentVote->comments_id = $commentId;
        }

        if( $commentVote->save(false) && $comment->save()){
            return $this->asJson([
                'status'=> true,
                'like'=>$count,
                'model1' =>CommentsVote::findOne(['comments_id'=>$commentId,'user'=>Yii::$app->user->getId(),'vote_type'=>1]),
                'model0' =>CommentsVote::findOne(['comments_id'=>$commentId,'user'=>Yii::$app->user->getId(),'vote_type'=>0]),
                'type' =>$type,
                'message' => Yii::t('oboom.comments', 'voteLikeAdd')
            ]);
        }

        return $this->asJson([
            'status'=> false,
            'ddd'=>'dddddd',
            'message' => Yii::t('oboom.comments', 'voteLikeNotAdd')
        ]);



    }

}

