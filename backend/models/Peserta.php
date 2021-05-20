<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tbl_peserta".
 *
 * @property int $tp_id
 * @property string $tp_nik
 * @property string $tp_nama_kk
 * @property string $tp_nikes
 * @property string $tp_status_kel
 * @property string $tp_nama_kel
 * @property string $tp_hr_pens
 * @property string $tp_hr_host
 * @property string $tp_band_posisi
 * @property string $tp_tgl_lahir
 * @property string $tp_umur
 * @property string $tp_gol
 * @property string $tp_tanggungan
 * @property string $tp_tgl_pens
 * @property string $tp_tgl_akhir_tanggunngan
 * @property string $tp_jenis_peserta
 * @property int $tp_jenis_kelamin
 * @property string $tp_no_bpjs
 * @property int $tp_flag_active
 */
class Peserta extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_peserta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tp_nikes','flag_deleted'], 'required'],
            [['tp_tgl_lahir', 'tp_tgl_pens', 'tp_tgl_akhir_tanggunngan'], 'safe'],
            [['tp_jenis_kelamin', 'tp_flag_active','kategori_host'], 'integer'],
            [['tp_nik', 'tp_nama_kk', 'tp_nikes', 'tp_status_kel', 'tp_nama_kel', 'tp_hr_pens', 'tp_hr_host', 'tp_band_posisi', 'tp_umur', 'tp_gol', 'tp_tanggungan', 'tp_jenis_peserta', 'tp_no_bpjs','tp_no_telp'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'tp_id' => 'ID',
            'tp_nik' => 'Nik',
            'tp_nama_kk' => 'Nama Kk',
            'tp_nikes' => 'Nikes',
            'tp_status_kel' => 'Status Kel',
            'tp_nama_kel' => 'Nama Kel',
            'tp_hr_pens' => 'Hr Pens',
            'tp_hr_host' => 'Hr Host',
            'tp_band_posisi' => 'Band Posisi',
            'tp_tgl_lahir' => 'Tgl Lahir',
            'tp_umur' => 'Umur',
            'tp_gol' => 'Gol',
            'tp_tanggungan' => 'Tanggungan',
            'tp_tgl_pens' => 'Tgl Pens',
            'kategori_host' => 'Kategori Peserta',
            'tp_tgl_akhir_tanggunngan' => 'Tgl Akhir Tanggunngan',
            'tp_jenis_peserta' => 'Klinik Faskes',
            'tp_jenis_kelamin' => 'Jenis Kelamin',
            'tp_no_bpjs' => 'No Bpjs',
            'tp_no_telp' => 'No Telp',
            'tp_flag_active' => 'Status Active',
        ];
    }
}
