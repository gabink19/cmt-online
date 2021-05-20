<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tbl_hr_pens".
 *
 * @property int $thp_id
 * @property string $thp_penamaan
 * @property string $thp_keterangan
 * @property int $flag_deleted
 */
class HrPens extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_hr_pens';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['thp_penamaan'], 'required'],
            [['flag_deleted'], 'integer'],
            [['thp_penamaan'], 'string', 'max' => 40],
            [['thp_keterangan'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'thp_id' => 'ID',
            'thp_penamaan' => 'Penamaan',
            'thp_keterangan' => 'Keterangan',
            'flag_deleted' => 'Flag Deleted',
        ];
    }
}
