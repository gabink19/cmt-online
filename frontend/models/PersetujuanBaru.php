<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "tbl_persetujuan_tindak".
 *
 * @property int $tpt_id
 * @property string $tpt_tp_nikes
 * @property int $tpt_td_id
 * @property resource $tpt_catatan_mitra
 * @property string $tpt_path_permintaan_tindak
 * @property string $tpt_flag_status
 * @property string $tpt_id_user_backend
 * @property resource $tpt_catatan_yakes
 * @property string $tpt_id_user_frontend
 * @property string $tpt_nama_mitra
 * @property string $tpt_nama_user_backend
 * @property string $tgl_permintaan
 * @property string $tgl_persetujuan
 * @property string $first_ip_backend
 * @property string $last_ip_backend
 * @property string $first_ip_frontend
 * @property string $last_ip_frontend
 * @property string $first_date_backend
 * @property string $last_date_backend
 * @property string $first_date_frontend
 * @property string $last_date_frontend
 * @property string $first_user_backend
 * @property string $last_user_backend
 * @property string $first_user_frontend
 * @property string $last_user_frontend
 */
class PersetujuanBaru extends \yii\db\ActiveRecord
{
    public $rekmedis;
    public $tujuan;
    public $start_periode;
    public $stop_periode;
    public $nama_pegawai;
    public $nama_peserta;
    public $diagnosa;
    public $history_catatan;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_persetujuan_tindak';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tpt_td_id','tpt_diagnosa','flag_deleted'], 'integer'],
            [['tpt_path_permintaan_tindak'], 'required', 'on' => 'create'],
            [['tpt_tp_nikes'], 'required'],
            [['tpt_catatan_mitra', 'tpt_catatan_yakes','tpt_uniq_code'], 'string'],
            [['tgl_permintaan','biaya','biaya_disetujui',  'tgl_persetujuan', 'first_date_backend', 'last_date_backend', 'first_date_frontend', 'last_date_frontend', 'tpt_id_user_backend', 'tpt_id_user_frontend'], 'safe'],
            [['tpt_tp_nikes', 'tpt_path_permintaan_tindak', 'tpt_flag_status', 'tpt_nama_mitra', 'tpt_nama_user_backend', 'first_ip_backend', 'last_ip_backend', 'first_ip_frontend', 'last_ip_frontend', 'first_user_backend', 'last_user_backend', 'first_user_frontend', 'last_user_frontend'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'tpt_id' => 'ID',
            'tpt_tp_nikes' => 'Nikes',
            'tpt_td_id' => 'Id Pendaftaran',
            'tpt_catatan_mitra' => 'Catatan Mitra',
            'tpt_path_permintaan_tindak' => 'Permintaan Tindak',
            'tpt_flag_status' => 'Flag Status',
            'tpt_id_user_backend' => 'User Backend',
            'tpt_catatan_yakes' => 'Catatan Yakes',
            'tpt_id_user_frontend' => 'User Frontend',
            'tpt_nama_mitra' => 'Nama Mitra',
            'tpt_nama_user_backend' => 'Nama User Backend',
            'tgl_permintaan' => 'Tgl Permintaan',
            'tgl_persetujuan' => 'Tgl Persetujuan',
            'tpt_diagnosa' => 'Diagnosa',
            'tpt_uniq_code' =>'Uniq_code',
            'biaya' => 'Biaya',
            'biaya_disetujui' => 'Biaya Disetujui',
            'first_ip_backend' => 'First Ip Backend',
            'last_ip_backend' => 'Last Ip Backend',
            'first_ip_frontend' => 'First Ip Frontend',
            'last_ip_frontend' => 'Last Ip Frontend',
            'first_date_backend' => 'First Date Backend',
            'last_date_backend' => 'Last Date Backend',
            'first_date_frontend' => 'First Date Frontend',
            'last_date_frontend' => 'Last Date Frontend',
            'first_user_backend' => 'First User Backend',
            'last_user_backend' => 'Last User Backend',
            'first_user_frontend' => 'First User Frontend',
            'last_user_frontend' => 'Last User Frontend',
        ];
    }
}
