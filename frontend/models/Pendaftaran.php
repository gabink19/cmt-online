<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "tbl_daftar".
 *
 * @property int $td_id
 * @property string $td_tp_nikes
 * @property int $td_tp_id
 * @property string $td_tgl_daftar
 * @property string $td_rekam_medis
 * @property string $td_tujuan
 * @property string $td_tp_nik
 * @property string $td_umur
 * @property string $td_tp_nama_kk
 * @property string $td_tp_no_bpjs
 * @property string $td_tp_band_posisi
 * @property string $td_tp_jenis_peserta
 * @property int $td_flag_status
 * @property string $td_mitra
 * @property string $first_user
 * @property string $first_ip
 * @property string $last_user
 * @property string $last_ip
 * @property string $first_date
 * @property string $last_date
 * @property resource $td_path_rujukan
 * @property string $td_hak_kelas
 */
class Pendaftaran extends \yii\db\ActiveRecord
{
    public $start_periode;
    public $stop_periode;
    public $kategori_peserta;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_daftar';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['td_tujuan','td_tp_nikes'], 'required'],
            // [['td_path_rujukan'], 'required', 'on' => 'create'],
            [['td_id', 'td_tp_id', 'td_flag_status','flag_deleted'], 'integer'],
            [['td_tgl_daftar', 'first_date', 'last_date','td_path_rujukan_2','td_path_rujukan_3'], 'safe'],
            [['td_path_rujukan'], 'string'],
            [['td_tp_nikes', 'td_rekam_medis',  'td_tp_nik', 'td_umur', 'td_tp_nama_kk','td_nama_kel', 'td_tp_no_bpjs', 'td_tp_band_posisi', 'td_tp_jenis_peserta', 'td_mitra', 'first_user', 'first_ip', 'last_user', 'last_ip'], 'string', 'max' => 255],
            [['td_hak_kelas'], 'string', 'max' => 20],
            [['td_id'], 'unique'],
            [['td_tp_nikes'], 'searching', 'on' => 'create'],
        ];
    }
    public function searching()
    {
        $cari = Peserta::find()->where(['=','tp_nikes', $this->td_tp_nikes])->andWhere(['<>','flag_deleted', 1])->one();
        if ($cari=='') {
            $this->addError('td_tp_nikes', 'Nikes Tidak Ditemukan');
        }else{
            $carilagi = Pendaftaran::find()->where(['=','td_tp_nikes', $this->td_tp_nikes])->andWhere(['<','td_flag_status', 6])->andWhere(['<>','flag_deleted', 1])->one();
            if ($carilagi!='') {
                $this->addError('td_tp_nikes', 'Nikes Sudah Digunakan.');
            }
        }
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'td_id' => 'ID',
            'td_tp_nikes' => 'Nikes',
            'td_tp_id' => 'Peserta',
            'td_tgl_daftar' => 'Tgl Daftar',
            'td_rekam_medis' => 'Rekam Medis',
            'td_tujuan' => 'Tujuan',
            'td_tp_nik' => 'Nik',
            'td_umur' => 'Umur',
            'td_tp_nama_kk' => 'Pegawai',
            'td_nama_kel' => 'Peserta',
            'td_tp_no_bpjs' => 'No Bpjs',
            'td_tp_band_posisi' => 'Band Posisi',
            'td_tp_jenis_peserta' => 'Klinik Faskes',
            'td_flag_status' => 'Flag Status',
            'td_mitra' => 'Mitra',
            'first_user' => 'First User',
            'first_ip' => 'First Ip',
            'last_user' => 'Last User',
            'last_ip' => 'Last Ip',
            'first_date' => 'First Date',
            'last_date' => 'Last Date',
            'td_path_rujukan' => 'Path Rujukan',
            'td_hak_kelas' => 'Hak Kelas',
            'td_path_rujukan_2'=>'Path Rujukan 2',
            'td_path_rujukan_3'=>'Path Rujukan 3',
            'flag_deleted' => 'flag_deleted',
        ];
    }
}
