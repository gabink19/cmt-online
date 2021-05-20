<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "tbl_notifikasi".
 *
 * @property int $tn_id
 * @property int $tn_kepada
 * @property int $tn_user_mitra
 * @property string $tn_tanggal
 * @property string $tn_judul
 * @property string $tn_teks
 * @property int $tn_type_notif 0 backend, 1 frontend
 * @property int $tn_telah_dikirim 0 belum dikirim, 1 sudah dikirim
 * @property int $tn_telah_dibaca 0 belum dibaca, 1 sudah dibaca
 * @property int $tn_tipe_notif 1 pendaftaran, 2 persetujuan, 3 billing sementara, 4 billing akhir
 * @property string $tn_link
 * @property int $tn_user_id
 * @property string $tn_dibaca_tanggal
 */
class Notifikasi extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_notifikasi';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['tn_kepada', 'tn_user_mitra', 'tn_type_notif', 'tn_telah_dikirim', 'tn_telah_dibaca', 'tn_tipe_notif', 'tn_user_id','flag_deleted','tn_type_rawat'], 'integer'],
            [['tn_tanggal', 'tn_dibaca_tanggal'], 'safe'],
            [['tn_link', 'tn_user_id', 'tn_dibaca_tanggal'], 'required'],
            [['tn_link'], 'string'],
            [['tn_judul'], 'string', 'max' => 50],
            [['tn_teks'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'tn_id' => 'ID',
            'tn_kepada' => 'Kepada',
            'tn_user_mitra' => 'User Mitra',
            'tn_tanggal' => 'Tanggal',
            'tn_judul' => 'Judul',
            'tn_teks' => 'Teks',
            'tn_type_notif' => 'Type Notif',
            'tn_telah_dikirim' => 'Telah Dikirim',
            'tn_telah_dibaca' => 'Telah Dibaca',
            'tn_tipe_notif' => 'Tipe Notif',
            'tn_link' => 'Link',
            'tn_user_id' => 'User ID',
            'tn_dibaca_tanggal' => 'Dibaca Tanggal',
            'tn_type_rawat' => 'Type Perawat',
        ];
    }
}
