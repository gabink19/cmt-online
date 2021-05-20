<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tbl_bidang".
 *
 * @property int $tb_id
 * @property string $tb_nama_bidang
 * @property string $tb_keterangan
 * @property int $tb_flag_akses 1 forntend, 0 backend
 * @property int $flag_deleted
 */
class Bidang extends \yii\db\ActiveRecord
{
    public $selectmenu;
    public $selectedmenu;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_bidang';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tb_nama_bidang', 'tb_keterangan', 'tb_flag_akses', 'flag_deleted'], 'required'],
            [['tb_flag_akses', 'flag_deleted'], 'integer'],
            [['tb_nama_bidang'], 'string', 'max' => 100],
            [['tb_keterangan'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'tb_id' => 'ID',
            'tb_nama_bidang' => 'Nama Bidang',
            'tb_keterangan' => 'Keterangan',
            'tb_flag_akses' => 'Flag Akses',
            'flag_deleted' => 'Flag Deleted',
        ];
    }
}
