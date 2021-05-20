<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property string $first_user
 * @property string $first_ip
 * @property string $first_update
 * @property string $last_user
 * @property string $last_ip
 * @property string $last_update
 * @property string $active_date
 * @property string $usermode
 * @property int $flag_multiple
 * @property string $last_action
 * @property string $ip
 * @property int $flag_login
 * @property string $lastvisit
 * @property string $no_telp
 * @property string $nama
 * @property int $bidang_user
 * @property int $flag_active
 * @property string $rs_mitra
 * @property int $bidang_mitra
 * @property string $alamat_rs
 * @property int $type_user 0:backend , 1:frontend
 */
class User extends \yii\db\ActiveRecord
{
    public $password_hash1;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password_hash', 'email', 'created_at', 'updated_at', 'active_date','type_user'], 'required'],
            [['status', 'created_at', 'updated_at', 'flag_multiple', 'flag_login', 'bidang_user', 'flag_active', 'bidang_mitra', 'type_user'], 'integer'],
            [['first_update', 'last_update', 'active_date', 'last_action', 'lastvisit', 'flag_mobile', 'expired_mobile'], 'safe'],
            [['username', 'password_hash', 'password_reset_token', 'email', 'no_telp', 'nama', 'rs_mitra', 'alamat_rs'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['first_user', 'last_user', 'usermode'], 'string', 'max' => 50],
            [['first_ip', 'last_ip', 'ip'], 'string', 'max' => 20],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
            // [['username'], 'cek'],
            // [['password_hash'], 'cek'],
        ];
    }

    public function cek()
    {
        if ($this->password_hash != $this->password_hash1) {
            $this->addError('password_hash1', 'Password tidak sama,cek kembali');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'first_user' => 'First User',
            'first_ip' => 'First Ip',
            'first_update' => 'First Update',
            'last_user' => 'Last User',
            'last_ip' => 'Last Ip',
            'last_update' => 'Last Update',
            'active_date' => 'Active Date',
            'usermode' => 'Usermode',
            'flag_multiple' => 'Flag Multiple',
            'last_action' => 'Last Action',
            'ip' => 'Ip',
            'flag_login' => 'Flag Login',
            'lastvisit' => 'Lastvisit',
            'no_telp' => 'No Telp',
            'nama' => 'Nama',
            'bidang_user' => 'Bidang User',
            'flag_active' => 'Flag Active',
            'rs_mitra' => 'Rs Mitra',
            'bidang_mitra' => 'Bidang Mitra',
            'alamat_rs' => 'Alamat Rs',
            'type_user' => 'Type User',
            'flag_mobile' => 'Flag Mobile',
            'expired_mobile' => 'Expired Mobile',
        ];
    }
}
