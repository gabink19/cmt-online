<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tbl_hr_host".
 *
 * @property int $thh_id
 * @property string $thh_penamaan
 * @property string $thh_keterangan
 * @property int $flag_deleted
 */
class HrHost extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_hr_host';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['thh_penamaan'], 'required'],
            [['flag_deleted'], 'integer'],
            [['thh_penamaan'], 'string', 'max' => 40],
            [['thh_keterangan'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'thh_id' => 'ID',
            'thh_penamaan' => 'Penamaan',
            'thh_keterangan' => 'Keterangan',
            'flag_deleted' => 'Flag Deleted',
        ];
    }
}
