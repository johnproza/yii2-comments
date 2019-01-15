<?php
/**
 * Created by PhpStorm.
 * User: john
 * Date: 15.01.2019
 * Time: 13:03
 */

namespace oboom\comments\models;
use Yii;
use yii\behaviors\TimestampBehavior;

class CommentsVote extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comments_vote';
    }

    /**
     * {@inheritdoc}
     */

    public function behaviors()
    {
        return [
            'timestamp' => [

                'class' => TimestampBehavior::className(),
                'updatedAtAttribute' => false,

             ],
        ];
    }

    public function rules()
    {
        return [
            [['user', 'created_at', 'comments_id'], 'required'],
            [['user', 'created_at', 'vote_type', 'comments_id'], 'integer'],
            [['comments_id'], 'exist', 'skipOnError' => true, 'targetClass' => Comments::className(), 'targetAttribute' => ['comments_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user' => 'User',
            'created_at' => 'Created At',
            'vote_type' => 'Vote Type',
            'comments_id' => 'Comments ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasOne(Comments::className(), ['id' => 'comments_id']);
    }
}