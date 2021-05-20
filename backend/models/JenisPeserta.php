<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tbl_jenis_peserta".
 *
 * @property int $tjp_id
 * @property string $tjp_penamaan
 * @property string $tjp_keterangan
 * @property int $flag_deleted
 */
class JenisPeserta extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_jenis_peserta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['flag_deleted'], 'integer'],
            [['tjp_penamaan', 'tjp_keterangan'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'tjp_id' => 'ID',
            'tjp_penamaan' => 'Penamaan',
            'tjp_keterangan' => 'Keterangan',
            'flag_deleted' => 'Flag Deleted',
        ];
    }
}
