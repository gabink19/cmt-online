<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tbl_billing_sementara".
 *
 * @property int $tbs_id
 * @property string $tbs_tp_nikes
 * @property int $tbs_td_id
 * @property resource $tbs_catatan_mitra
 * @property string $tbs_path_billing
 * @property string $tbs_flag_status
 * @property string $tbs_id_user_backend
 * @property resource $tbs_catatan_yakes
 * @property string $tbs_id_user_frontend
 * @property string $tbs_nama_mitra
 * @property string $tbs_nama_user_backend
 * @property string $tgl_billing tgl frontend mengirim billing
 * @property string $tgl_billing_diresponse tgl backend meresponse billing
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
 */
class BillingSementara extends \yii\db\ActiveRecord
{
    public $rekmed;
    public $tujuan;
    public $peserta;
    public $pegawai;
    public $hakkelas;
    public $jenis_peserta;
    public $start_periode;
    public $stop_periode;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_billing_sementara';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tbs_td_id', 'flag_deleted'], 'integer'],
            [['tbs_path_billing'], 'required', 'on' => 'create'],
            [['tbs_catatan_mitra', 'tbs_catatan_yakes'], 'string'],
            [['tbs_biaya'], 'safe'],
            [['tgl_billing', 'tgl_billing_diresponse', 'first_date_backend', 'last_date_backend', 'tbs_id_user_backend','first_date_frontend', 'last_date_frontend', 'tbs_id_user_frontend'], 'safe'],
            [['tbs_tp_nikes', 'tbs_path_billing', 'tbs_flag_status',  'tbs_nama_mitra', 'tbs_nama_user_backend', 'first_ip_backend', 'last_ip_backend', 'first_ip_frontend', 'last_ip_frontend', 'first_user_backend', 'last_user_backend', 'first_user_frontend', 'last_user_frontend'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'tbs_id' => 'ID',
            'tbs_tp_nikes' => 'Nikes',
            'tbs_td_id' => 'ID Pendaftaran',
            'tbs_catatan_mitra' => 'Catatan Mitra',
            'tbs_path_billing' => 'Path Billing',
            'tbs_flag_status' => 'Flag Status',
            'tbs_id_user_backend' => 'Id User Backend',
            'tbs_catatan_yakes' => 'Catatan Yakes',
            'tbs_id_user_frontend' => 'Id User Frontend',
            'tbs_nama_mitra' => 'Nama Mitra',
            'tbs_nama_user_backend' => 'Nama User Backend',
            'tgl_billing' => 'Tgl Billing',
            'tgl_billing_diresponse' => 'Tgl Billing Diresponse',
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
            'tbs_biaya' => 'Biaya',
        ];
    }
}
