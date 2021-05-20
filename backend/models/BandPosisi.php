<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tbl_band_posisi".
 *
 * @property int $tbp_id
 * @property string $tbp_penamaan
 * @property string $tbp_keterangan
 * @property int $flag_deleted
 */
class BandPosisi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_band_posisi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['flag_deleted'], 'integer'],
            [['tbp_penamaan', 'tbp_keterangan','tbp_grade'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'tbp_id' => 'ID',
            'tbp_penamaan' => 'Penamaan',
            'tbp_keterangan' => 'Keterangan',
            'flag_deleted' => 'Flag Deleted',
            'tbp_grade' => 'Grade',
        ];
    }
}
