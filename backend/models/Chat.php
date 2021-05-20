<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "chat".
 *
 * @property int $id
 * @property int $userId
 * @property int $to
 * @property string $message
 * @property string $updateDate
 */
class Chat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'chat';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['userId'], 'integer'],
            [['message', 'idroom'], 'string'],
            [['updateDate','path'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'userId' => 'User ID',
            'idroom' => 'IDROOM',
            'message' => 'Message',
            'updateDate' => 'Update Date',
            'path' => 'Path',
        ];
    }
}
