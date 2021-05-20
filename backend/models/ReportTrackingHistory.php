<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tbl_billing_final".
 *
 * @property int $tbs_id
 * @property string $tbs_tp_nikes
 * @property int $tbs_td_id
 * @property resource $tbs_catatan_mitra
 * @property resource $tbs_path_billing
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
 * @property double $tbs_biaya
 */
class ReportTrackingHistory extends \yii\db\ActiveRecord
{
    public $start_periode;
    public $stop_periode;
    public $tujuan;
    public $host;
    public $mitra;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_billing_final';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tbs_td_id', 'flag_deleted','tbs_diagnosa'], 'integer'],
            [['tbs_catatan_mitra', 'tbs_path_billing', 'tbs_catatan_yakes'], 'string'],
            [['tgl_billing', 'tgl_billing_diresponse', 'first_date_backend', 'last_date_backend', 'first_date_frontend', 'last_date_frontend'], 'safe'],
            [['tbs_biaya'], 'number'],
            [['tbs_tp_nikes', 'tbs_flag_status', 'tbs_id_user_backend', 'tbs_id_user_frontend', 'tbs_nama_mitra', 'tbs_nama_user_backend', 'first_ip_backend', 'last_ip_backend', 'first_ip_frontend', 'last_ip_frontend', 'first_user_backend', 'last_user_backend', 'first_user_frontend', 'last_user_frontend'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'tbs_id' => 'ID',
            'tbs_tp_nikes' => 'Tp Nikes',
            'tbs_td_id' => 'Td ID',
            'tbs_catatan_mitra' => 'Catatan Mitra',
            'tbs_path_billing' => 'Path Billing',
            'tbs_flag_status' => 'Flag Status',
            'tbs_id_user_backend' => 'Id User Backend',
            'tbs_catatan_yakes' => 'Catatan Yakes',
            'tbs_id_user_frontend' => 'Id User Frontend',
            'tbs_nama_mitra' => 'Nama Mitra',
            'tbs_nama_user_backend' => 'Nama User Backend',
            'tgl_billing' => 'Tanggal Masuk',
            'tgl_billing_diresponse' => 'Tanggal Keluar',
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
            'tbs_diagnosa' => 'Diagnosa'
        ];
    }
}
