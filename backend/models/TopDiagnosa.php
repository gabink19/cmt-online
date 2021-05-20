<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tbl_top_diagnosa".
 *
 * @property int $ttd_id
 * @property string $ttd_penamaan
 * @property string $ttd_deskripsi
 * @property resource $ttd_tdg_kode
 * @property int $flag_deleted
 */
class TopDiagnosa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_top_diagnosa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ttd_id'], 'required'],
            [['ttd_id', 'flag_deleted'], 'integer'],
            [['ttd_tdg_kode'], 'safe'],
            [['ttd_penamaan', 'ttd_deskripsi'], 'string', 'max' => 255],
            [['ttd_id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'ttd_id' => 'ID',
            'ttd_penamaan' => 'Penamaan',
            'ttd_deskripsi' => 'Deskripsi',
            'ttd_tdg_kode' => 'Kode',
            'flag_deleted' => 'Flag Deleted',
        ];
    }
}
