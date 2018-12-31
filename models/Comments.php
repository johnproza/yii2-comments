<?php

namespace oboom\comments\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\web\User;

/**
 * This is the model class for table "comments".
 *
 * @property int $id
 * @property string $content
 * @property int $created_by
 * @property int $updated_by
 * @property string $relatedTo
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property string $entity
 * @property int $entityId
 */
class Comments extends \yii\db\ActiveRecord
{

    CONST STATUS_BLOCKED = 0;
    CONST STATUS_ACTIVE = 1;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comments';
    }


    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['content', 'created_by', 'updated_by'], 'required'],
            [['content'], 'string'],
            [['created_by', 'updated_by', 'status', 'created_at', 'updated_at', 'entityId'], 'integer'],
            [['relatedTo'], 'string', 'max' => 500],
            [['entity'], 'string', 'max' => 10],

            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_BLOCKED]],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('oboom.comments', 'id'),
            'content' => Yii::t('oboom.comments', 'content'),
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'relatedTo' => 'Related To',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'entity' => 'Entity',
            'entityId' => 'Entity ID',
        ];
    }
 

    static public function getComments($entity,$entityId){
        return Comments::findAll(['entity'=>$entity,'entityId'=>$entityId]);
    }

    public function getAuthorName()
    {
        if ($this->author->hasMethod('getUsername')) {
            return $this->author->getUsername();
        }
        return $this->author->username;
    }

    public function getPostedDate()
    {
        return Yii::$app->formatter->asRelativeTime($this->created_at);
    }

    public function getContent()
    {
        return nl2br($this->content);
    }

    public function getAvatar()
    {
        if ($this->author->hasMethod('getAvatar')) {
            return $this->author->getAvatar();
        }
        return 'http://www.gravatar.com/avatar?d=mm&f=y&s=60';
    }


    public function getAuthor()
    {
        return $this->hasOne(Yii::$app->getModule('comments')->userIdentityClass, ['id' => 'created_by']);
    }
}