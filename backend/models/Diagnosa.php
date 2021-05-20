<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tbl_diagnosa".
 *
 * @property int $tdg_id
 * @property string $tdg_penamaan
 * @property string $tdg_keterangan
 * @property string $tdg_kode
 * @property int $flag_deleted
 */
class Diagnosa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_diagnosa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['flag_deleted'], 'integer'],
            [['tdg_penamaan', 'tdg_keterangan'], 'string', 'max' => 255],
            [['tdg_kode'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'tdg_id' => 'ID',
            'tdg_penamaan' => 'Penamaan',
            'tdg_keterangan' => 'Keterangan',
            'tdg_kode' => 'Kode',
            'flag_deleted' => 'Flag Deleted',
        ];
    }
}
