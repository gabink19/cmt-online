<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tbl_persetujuan_tindak".
 *
 * @property int $tpt_id
 * @property string $tpt_uniq_code
 * @property string $tpt_tp_nikes
 * @property int $tpt_td_id
 * @property resource $tpt_catatan_mitra
 * @property resource $tpt_path_permintaan_tindak
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
 * @property int $flag_deleted 0: not deleted,1:deleted
 * @property int $tpt_diagnosa
 * @property resource $history_note
 * @property double $biaya
 * @property double $biaya_disetujui
 */
class PersetujuanTindak extends \yii\db\ActiveRecord
{
    public $priode;
    public $approve;
    public $tujuan;
    public $start_periode;
    public $stop_periode;
    public $start_periode2;
    public $stop_periode2;
    public $tahuntri;
    public $triwulan;
    public $status;
    public $diagnosa;
    public $costsaving;

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
            [['tpt_td_id', 'flag_deleted', 'tpt_diagnosa'], 'integer'],
            [['tpt_catatan_mitra', 'tpt_path_permintaan_tindak', 'tpt_catatan_yakes', 'history_note'], 'string'],
            [['tgl_permintaan', 'tgl_persetujuan', 'first_date_backend', 'last_date_backend', 'first_date_frontend', 'last_date_frontend'], 'safe'],
            [['biaya', 'biaya_disetujui'], 'number'],
            [['tpt_uniq_code', 'tpt_tp_nikes', 'tpt_flag_status', 'tpt_id_user_backend', 'tpt_id_user_frontend', 'tpt_nama_mitra', 'tpt_nama_user_backend', 'first_ip_backend', 'last_ip_backend', 'first_ip_frontend', 'last_ip_frontend', 'first_user_backend', 'last_user_backend', 'first_user_frontend', 'last_user_frontend'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'tpt_id' => 'ID',
            'tpt_uniq_code' => 'Uniq Code',
            'tpt_tp_nikes' => 'Nikes',
            'tpt_td_id' => 'ID',
            'tpt_catatan_mitra' => 'Catatan Mitra',
            'tpt_path_permintaan_tindak' => 'Path Permintaan Tindak',
            'tpt_flag_status' => 'Flag Status',
            'tpt_id_user_backend' => 'Id User Backend',
            'tpt_catatan_yakes' => 'Catatan Yakes',
            'tpt_id_user_frontend' => 'Id User Frontend',
            'tpt_nama_mitra' => 'Nama Mitra',
            'tpt_nama_user_backend' => 'Nama User Backend',
            'tgl_permintaan' => 'Tanggal Masuk',
            'tgl_persetujuan' => 'Tanggal Approve',
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
            'flag_deleted' => 'Flag Deleted',
            'tpt_diagnosa' => 'Diagnosa',
            'history_note' => 'History Note',
            'biaya' => 'Biaya',
            'biaya_disetujui' => 'Biaya Disetujui',
            'start_periode' => 'Start Bulan',
            'stop_periode' => 'Stop Bulan',
            'start_periode2' => 'Start Tahun',
            'stop_periode2' => 'Stop Tahun',
            'tahuntri' => 'Tahun Triwulan',
            'triwulan' => 'Triwulan Ke-'
        ];
    }
}
