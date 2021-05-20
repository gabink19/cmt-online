<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tbl_rujukan".
 *
 * @property int $id
 * @property string $tr_no_regis
 * @property string $tr_no_rujukan
 * @property string $tr_tujuan
 * @property string $tr_nama_dokter
 * @property string $tr_nama_pasien
 * @property string $tr_umur
 * @property string $tr_nikes
 * @property string $tr_nama_kk
 * @property string $tr_band
 * @property string $tr_hak_kelas
 * @property resource $tr_anamnese
 * @property string $tr_diagnosa
 * @property resource $tr_tindakan
 * @property string $tr_tgl_rujukan
 * @property string $tr_nama_jaminan
 * @property string $flag_deleted
 * @property string $path_file
 * @property int $tr_td_id
 * @property string $date_create
 */
class Rujukan extends \yii\db\ActiveRecord
{
    public $kategori_host;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_rujukan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tr_anamnese', 'tr_tindakan'], 'string'],
            [['tr_tgl_rujukan', 'date_create'], 'safe'],
            [['tr_td_id'], 'integer'],
            [['tr_no_regis', 'tr_no_rujukan', 'tr_tujuan', 'tr_nama_dokter', 'tr_nama_pasien', 'tr_umur', 'tr_nikes', 'tr_nama_kk', 'tr_band', 'tr_hak_kelas', 'tr_diagnosa', 'tr_nama_jaminan', 'flag_deleted', 'path_file'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tr_no_regis' => 'Tr No Regis',
            'tr_no_rujukan' => 'Tr No Rujukan',
            'tr_tujuan' => 'Tr Tujuan',
            'tr_nama_dokter' => 'Tr Nama Dokter',
            'tr_nama_pasien' => 'Tr Nama Pasien',
            'tr_umur' => 'Tr Umur',
            'tr_nikes' => 'Tr Nikes',
            'tr_nama_kk' => 'Tr Nama Kk',
            'tr_band' => 'Tr Band',
            'tr_hak_kelas' => 'Tr Hak Kelas',
            'tr_anamnese' => 'Tr Anamnese',
            'tr_diagnosa' => 'Tr Diagnosa',
            'tr_tindakan' => 'Tr Tindakan',
            'tr_tgl_rujukan' => 'Tr Tgl Rujukan',
            'tr_nama_jaminan' => 'Tr Nama Jaminan',
            'flag_deleted' => 'Flag Deleted',
            'path_file' => 'Path File',
            'tr_td_id' => 'Tr Td ID',
            'date_create' => 'Date Create',
        ];
    }
}
