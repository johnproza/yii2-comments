<?php

namespace oboom\comments\models;

use Yii;

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
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'comments';
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
}