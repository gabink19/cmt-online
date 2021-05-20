<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tbl_tanggungan".
 *
 * @property int $tt_id
 * @property string $tt_penamaan
 * @property string $tt_keterangan
 * @property int $flag_deleted
 */
class Tanggungan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_tanggungan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['flag_deleted'], 'integer'],
            [['tt_penamaan', 'tt_keterangan'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'tt_id' => 'ID',
            'tt_penamaan' => 'Penamaan',
            'tt_keterangan' => 'Keterangan',
            'flag_deleted' => 'Flag Deleted',
        ];
    }
}
