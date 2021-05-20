<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tbl_golongan".
 *
 * @property int $tg_id
 * @property string $tg_penamaan
 * @property string $tg_keterangan
 * @property int $flag_deleted
 */
class Golongan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_golongan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['flag_deleted'], 'integer'],
            [['tg_penamaan', 'tg_keterangan'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'tg_id' => 'ID',
            'tg_penamaan' => 'Penamaan',
            'tg_keterangan' => 'Keterangan',
            'flag_deleted' => 'Flag Deleted',
        ];
    }
}
