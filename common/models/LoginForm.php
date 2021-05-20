<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;

    private $_user;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            $web = basename(Yii::getAlias('@app'));
            // echo "<pre>"; print_r();echo "</pre>";die();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Username atau Password tidak benar.');
            }else{
	            if ($web=='backend' && $user->type_user==1) {
	                $this->addError($attribute, 'User Tersebut hanya bisa login di frontend.');
	            }
	            if ($web=='frontend' && $user->type_user==0) {
	                $this->addError($attribute, 'User Tersebut hanya bisa login di backend.');
	            }
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login($flag_mobile='',$IdUser='')
    {
        if ($this->validate() || ($flag_mobile=='true' && $IdUser!='')) {

            if ($flag_mobile=='true' && $IdUser != '') {
                $session = Yii::$app->session;
                $session->destroy();
                $session = Yii::$app->session;
                $session->set('user',User::findOne($IdUser));
                $user = User::findOne($IdUser);
            }else{
                $session = Yii::$app->session;
                $session->set('user',$this->getUser());
                $user = $this->getUser();
            }

            $query = 'SELECT thp_id,thp_penamaan FROM tbl_hr_pens';
            $result = Yii::$app->db->createCommand($query)->queryAll();
            $session->set('pens',$result);


            $query = 'SELECT thh_id,thh_penamaan FROM tbl_hr_host';
            $result = Yii::$app->db->createCommand($query)->queryAll();
            $session->set('host',$result);

            $query = 'SELECT tbp_id,tbp_penamaan FROM tbl_band_posisi';
            $result = Yii::$app->db->createCommand($query)->queryAll();
            $session->set('band',$result);

            $query = 'SELECT tt_id,tt_penamaan FROM tbl_tanggungan';
            $result = Yii::$app->db->createCommand($query)->queryAll();
            $session->set('tanggungan',$result);

            $query = 'SELECT tg_id,tg_penamaan FROM tbl_golongan';
            $result = Yii::$app->db->createCommand($query)->queryAll();
            $session->set('golongan',$result);

            $query = 'SELECT tjp_id,tjp_penamaan FROM tbl_jenis_peserta';
            $result = Yii::$app->db->createCommand($query)->queryAll();
            $session->set('jenis_peserta',$result);

            $query = 'SELECT tdg_id,tdg_penamaan FROM tbl_diagnosa';
            $result = Yii::$app->db->createCommand($query)->queryAll();
            $session->set('diagnosa',$result);

            $query = 'SELECT * FROM menu WHERE id IN (SELECT id_menu FROM `role_access` WHERE id_bidang="'.$user->bidang_mitra.'") AND status=1 ORDER BY `order` ASC';
            $result = Yii::$app->db->createCommand($query)->queryAll();
            $session->set('menu',$result);

            $query = 'SELECT route FROM menu WHERE id IN (SELECT id_menu FROM `role_access` WHERE id_bidang="'.$user->bidang_mitra.'") AND status=2 ORDER BY `order` ASC';
            $result = Yii::$app->db->createCommand($query)->queryAll();
            $session->set('crud_akses',$result);


            if ($flag_mobile=='true') {
                // echo "<pre>a"; print_r($session->get('menu'));echo "</pre>";die();
                // Yii::$app->user->login($user, $this->rememberMe ? 3600 * 24 * 30 : 0);
                return true;
            }else{
                $session->set('notif','Login');
                // echo "<pre>b"; print_r($session->get('menu'));echo "</pre>";die();
                return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
            }
        }
        
        return false;
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function updateStatLogin($username)
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        $last_visit = date('Y-m-d H:i:s');
        $query = "UPDATE `user` SET `flag_login`='1',`ip`='$ip',`lastvisit`='$last_visit' WHERE `username`='$username'";
        $execute = Yii::$app->db->createCommand($query)->execute();
        if ($execute) {
            $result = ['error_desc'=>'success','error_code'=>200]; 
            return $result;
            die();
        }else{
            $result = ['error_desc'=>'failed','error_code'=>100]; 
            return $result;
            die();
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return bool whether the user is logged in successfully
     */
    public function updateStatLogout($username)
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        $last_visit = date('Y-m-d H:i:s');
        $query = "UPDATE `user` SET `flag_login`='0',`last_ip`='$ip',`lastvisit`='$last_visit' WHERE `username`='$username'";
        $execute = Yii::$app->db->createCommand($query)->execute();
        if ($execute) {
            $result = ['error_desc'=>'success','error_code'=>200]; 
            return $result;
            die();
        }else{
            $result = ['error_desc'=>'failed','error_code'=>100]; 
            return $result;
            die();
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
