<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tbl_hak_kelas".
 *
 * @property int $thk_id
 * @property string $thk_rumah_sakit
 * @property int $id_user
 * @property string $I
 * @property string $II
 * @property string $III
 * @property string $IV
 * @property string $V
 * @property string $VI
 * @property string $VII
 * @property int $flag_active
 * @property int $flag_deleted
 */
class HakKelas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_hak_kelas';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['thk_rumah_sakit', 'id_user', 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'flag_active', 'flag_deleted'], 'required'],
            [['id_user', 'flag_active', 'flag_deleted'], 'integer'],
            [['thk_rumah_sakit','thk_kategori_host'], 'string', 'max' => 255],
            [['I', 'II', 'III', 'IV', 'V', 'VI', 'VII','A', 'B', 'C', 'D'], 'string', 'max' => 25],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'thk_id' => 'ID',
            'thk_rumah_sakit' => 'Rumah Sakit',
            'id_user' => 'Id User',
            'I' => 'I',
            'II' => 'Ii',
            'III' => 'Iii',
            'IV' => 'Iv',
            'V' => 'V',
            'VI' => 'Vi',
            'VII' => 'Vii',
            'flag_active' => 'Flag Active',
            'flag_deleted' => 'Flag Deleted',
            'thk_kategori_host' => 'Kategori Host',
        ];
    }
}
