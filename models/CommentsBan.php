<?php

namespace oboom\comments\models;

use Yii;

/**
 * This is the model class for table "comments_ban".
 *
 * @property int $id
 * @property int $expires
 * @property string $reason
 * @property int $user_id
 *
 * @property User $user
 */
class CommentsBan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comments_ban';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['expires', 'user_id'], 'integer'],
            [['reason'], 'string', 'max' => 250],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Yii::$app->getModule('comments')->userIdentityClass, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'expires' => Yii::t('oboom.comments', 'expires'),
            'reason' => Yii::t('oboom.comments', 'reason'),
            'user_id' => Yii::t('oboom.comments', 'user_id'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Yii::$app->getModule('comments')->userIdentityClass, ['id' => 'user_id']);
    }
}
