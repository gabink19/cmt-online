<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tbl_activity_user".
 *
 * @property int $id
 * @property string $tanggal
 * @property resource $berita
 * @property string $username
 * @property string $ip
 */
class ActivityUser extends \yii\db\ActiveRecord
{
    public $start_periode;
    public $stop_periode;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_activity_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['tanggal'], 'safe'],
            [['berita'], 'string'],
            [['username', 'ip'], 'string', 'max' => 255],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tanggal' => 'Tanggal',
            'berita' => 'Berita',
            'username' => 'Username',
            'ip' => 'Ip',
        ];
    }
}
