<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\Pendaftaran;
use frontend\models\SignupForm;
use backend\models\User;
use frontend\models\ContactForm;
use yii\helpers\Url;
use frontend\models\Chat;

/**
 * Site controller
 */
class SiteController extends MainController
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionCheckNotif($link)
    {
        $query = 'SELECT * FROM tbl_notifikasi WHERE tn_link like "%'.$link.'%" AND tn_user_mitra="'.@Yii::$app->user->id.'" AND tn_type_notif="1" AND tn_telah_dikirim="1" AND tn_telah_dibaca="0" AND flag_deleted="0"' ;
        $result['data'] = Yii::$app->db->createCommand($query)->queryAll();
        if (!empty($result['data'])) {
          foreach ($result['data'] as $key => $value) {
              $result['data'][$key]['tn_link']=str_replace('/frontend', '', $value['tn_link']);
            if (mb_substr($result['data'][$key]['tn_link'], 0, 2, "UTF-8")=='//') {
                $result['data'][$key]['tn_link'] = str_replace('//', '/', $result['data'][$key]['tn_link']);
            }
          }
        }
        $result['jumlah'] = count($result['data']);
        return json_encode($result);
    }
    public function actionTest()
    {
      $getTemplate = 'SELECT * FROM tbl_global_parameter where name="email_ke_backend" LIMIT 1';
      $getTemplate = Yii::$app->db->createCommand($getTemplate)->queryOne();
      $to = $getTemplate['to'];
      $from = $getTemplate['from'];
      $body = $getTemplate['value'];
      $body = str_replace('[nikes]', '101010', $body);
      $body = str_replace('[nama_pasien]', 'Gibran', $body);
      $body = str_replace('[nama_karyawan]', 'Gibran', $body);
      $body = str_replace('[mitra_rs]', 'RS PERTAMINA', $body);
      $body = str_replace('[hak_kelas]', 'KELAS I', $body);
      $body = str_replace('[catatan_mitra]', 'CATATAN MITRA CEPAT SEMBUH', $body);
      $body = str_replace('[nominal]', '1000000', $body);
      $subject = 'Persetujuan Tindakan';
      $attach = '/home/developt/web-cmt-online/cmt-online/public/uploadPermintaan/Report_Daily_LBA_20191211_2019-12-22_22:35:27.pdf';
      // echo "<pre>"; print_r($getTemplate);echo "</pre>";die();
      $this->SendEmail($to,$from,$subject,$body,$attach);
    }
    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    { 

        $session = Yii::$app->session;
        $user = $session->get('user');
    	  if(Yii::$app->user->isGuest) {
                Yii::$app->user->logout();
    			return $this->redirect(['site/portal']);
    		}
		// else{
		// 	$lastvisit = Yii::$app->user->identity->lastvisit;
		// 	$now = date('Y-m-d H:i:s');
		// 	$to_time = strtotime($now);
		// 	$from_time = strtotime($lastvisit);
		// 	$menit = round(abs($to_time - $from_time) / 60,2);
		// 	if ($menit>60) {
  //       		Yii::$app->user->logout();
		// 	}
		// }
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $this->historyUser('[LOGIN]',$user,$ip);
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }


    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionPortal()
    {
      // echo "<pre>"; print_r(this);echo "</pre>";die();
      $model = new LoginForm();
      return $this->render('portal', [
          'model' => $model,
      ]);
    }


    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionContact()
    {
      // echo "<pre>"; print_r(this);echo "</pre>";die();
      $model = new LoginForm();
      return $this->render('portal', [
          'model' => $model,
      ]);
    }

    public function actionSendmail($value='')
    {
      	if (isset($_POST['email'])) {
      		$from = $_POST['email'];
      		$name = $_POST['name'];
      		$subject = $_POST['subject']." (From : ".$name." | ".$from.")";
      		$body = $_POST['message'];
	      	$this->SendEmail('cmtonline.care@gmail.com',$from,$subject,$body);
	        Yii::$app->session->set('notif','');
      	}
      	echo json_encode("success");die();
        // return $this->redirect(['site/contact']);
    }


    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionInformation()
    {
      // echo "<pre>"; print_r(this);echo "</pre>";die();
      $model = new LoginForm();
      return $this->render('portal', [
          'model' => $model,
      ]);
    }

 	public function actionSendchat()
    {
        if ($_POST) {
            $model = new Chat();
            $model->userId = $_POST['id'];
            $model->message = $_POST['pesan'];
            $model->idroom = $_POST['room'];
            $model->updateDate = date('Y-m-d H:i:s');
            $model->status_read = 0;
            $harini = date('Y-m-d', strtotime($model->updateDate));
            $today = date('Y-m-d');
            $date = date('d/m/y H:i', strtotime($model->updateDate));
            if ($harini==$today) {
                $date = date('H:i', strtotime($model->updateDate));
            }
            if ($model->save()) {
                $array = ['status'=>'success', 'hour'=>$date];
                return json_encode($array);
            }
        }
    }
    public function actionSendfile()
    {
        // echo "<pre>"; print_r($_SERVER);echo "</pre>";;die();
        if ($_GET) {
            $model = new Chat();
            $model->userId = $_GET['id'];
            $model->idroom = $_GET['room'];
            $model->updateDate = date('Y-m-d H:i:s');
            $model->status_read = 0;
            $harini = date('Y-m-d', strtotime($model->updateDate));
            $today = date('Y-m-d');
            $date = date('d/m/y H:i', strtotime($model->updateDate));
            if ($harini==$today) {
                $date = date('H:i', strtotime($model->updateDate));
            }

            $uploads_dir = Yii::$app->params['pathChat'];
            $explode = explode('.', $_FILES['file']['name']);
            $ext = end($explode);
            $name = date('Ymd-his').'_'.str_replace('_', '-', $model->idroom)."_".$explode[0].".".$ext;
            if (move_uploaded_file($_FILES['file']['tmp_name'], "$uploads_dir/$name")) {
                $model->path = "$uploads_dir/$name";
                if ($model->save()) {
                    $message = '<a href="'.Url::to(['download'])."&filename=".$model->path.'" target="_blank">'.$name.'</a>';
                    $array = ['status'=>'success', 'hour'=>$date,'name'=>$message];
                    return json_encode($array);
                }
            }else{
                return json_encode('false');
            }

        }
    }
    public function actionListuser()
    {
    	  $id = $_POST['id'];
        $type_user = User::findOne($id)->type_user;
    	  $query = "SELECT id,username from user where type_user<>'".$type_user."' AND bidang_mitra=6 order by username asc";
        $command = Yii::$app->db->createCommand($query)->queryAll();
        $array = [];
        foreach ($command as $key => $value) {
        	$array[$value['id']] = $value['username'];
        }

        return json_encode($array);
    }
    public function actionNotifChat()
    {
      $idme = Yii::$app->user->identity->id;
      $type_user = User::findOne($idme)->type_user;
      $query = "SELECT id from user where type_user<>'".$type_user."' AND bidang_mitra=6 order by username asc LIMIT 1";
      $lawan = Yii::$app->db->createCommand($query)->queryScalar();

      $query = "SELECT count(*) as total from chat where ((idroom='".$idme."_".$lawan."') or (idroom='".$lawan."_".$idme."')) and status_read<>1 order by updateDate asc";
      $command = Yii::$app->db->createCommand($query)->queryScalar();

      return $command;
    }
    public function actionGetchat()
    {
    	$room = $_POST['room'];
    	$exp = explode('_', $room);
    	$exp1 = $exp[0];
    	$exp2 = $exp[1];
        $query = "SELECT id,userId,updateDate,message,path from chat where ((idroom='".$exp1."_".$exp2."') or (idroom='".$exp2."_".$exp1."')) order by updateDate asc";
        $command = Yii::$app->db->createCommand($query)->queryAll();
        $array=[];
        foreach ($command as $key => $value) {
            if (Yii::$app->user->identity->id != $value['userId']) {
                $modchat = Chat::findOne($value['id']);
                $modchat->status_read = 1;
                $modchat->save();
            }
            $nama = User::findOne($value['userId']);
            $harini = date('Y-m-d', strtotime($value['updateDate']));
            $today = date('Y-m-d');
            $date = date('d/m/y H:i', strtotime($value['updateDate']));
            if ($harini==$today) {
                $date = date('H:i', strtotime($value['updateDate']));
            }
            if ($value['path']!='') {
                $expoder = explode('/', $value['path']);
                $ext = explode('.', end($expoder));
                if (end($ext)=='jpg'||end($ext)=='jpeg'||end($ext)=='png') {
                    $message = '<a href="'.Url::to(['download'])."&filename=".$value['path'].'" target="_blank"><img src="'.Url::to(['download'])."&filename=".$value['path'].'" width="200px"></a>';
                }else{
                    $message = '<a href="'.Url::to(['download'])."&filename=".$value['path'].'" target="_blank">'.end($expoder).'</a>';
                }
                $array[] = ['userId'=>$value['userId'],'id'=>$value['id'],'message'=>$message,'updateDate'=>$date,'nama'=>$nama->username];
            }else{
                $array[] = ['userId'=>$value['userId'],'id'=>$value['id'],'message'=>$value['message'],'updateDate'=>$date,'nama'=>$nama->username];
            }
        }
        return json_encode($array);
    }
    public function actionChecknew($lastid,$idroom,$user)
    {
    	$exp = explode('_', $idroom);
    	$exp1 = $exp[0];
    	$exp2 = $exp[1];
        $query = "SELECT MAX(id) from chat where ((idroom='".$exp1."_".$exp2."') or (idroom='".$exp2."_".$exp1."')) and userId <> '".$user."' order by updateDate desc LIMIT 1";
        $idquery = Yii::$app->db->createCommand($query)->queryScalar();
        // echo "<pre>"; print_r($query);echo "</pre>";die();
        if ($idquery!=$lastid) {
            $query = "SELECT id,userId,updateDate,message,path from chat where id=$idquery order by updateDate asc";
            $command = Yii::$app->db->createCommand($query)->queryAll();
            $modchat = Chat::findOne($idquery);
            $modchat->status_read = 1;
            $modchat->save();
            $array=[];
            foreach ($command as $key => $value) {
                $nama = User::findOne($value['userId']);
                $harini = date('Y-m-d', strtotime($value['updateDate']));
                $today = date('Y-m-d');
                $date = date('d/m/y H:i', strtotime($value['updateDate']));
                if ($harini==$today) {
                    $date = date('H:i', strtotime($value['updateDate']));
                }
                if ($value['path']!='') {
                    $expoder = explode('/', $value['path']);
                    $message = '<a href="'.Url::to(['download'])."&filename=".$value['path'].'" target="_blank">'.end($expoder).'</a>';
                    $array[] = ['id'=>$value['id'],'userId'=>$value['userId'],'message'=>$message,'updateDate'=>$date,'nama'=>$nama->username];
                }else{
                    $array[] = ['id'=>$value['id'],'userId'=>$value['userId'],'message'=>$value['message'],'updateDate'=>$date,'nama'=>$nama->username];
                }
            }
            return json_encode($array);
        }

        return 'false';
    }

    public function actionDownload($filename)
    {
        // $filename = 'Test.pdf'; // of course find the exact filename....        
        header('Pragma: public');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Cache-Control: private', false); // required for certain browsers 
        header('Content-Type: application/octet-stream');

        header('Content-Disposition: attachment; filename="'. basename($filename) . '";');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . filesize($filename));

        readfile($filename);

        exit;
    }
    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        $this->historyUser('[LOGOUT]',$user,$ip);
        $session = Yii::$app->session;
        $session->destroy();
        
        Yii::$app->user->logout();
        return $this->redirect(['site/login']);
    }

    // /**
    //  * Displays contact page.
    //  *
    //  * @return mixed
    //  */
    // public function actionContact()
    // {
    //     $model = new ContactForm();
    //     if ($model->load(Yii::$app->request->post()) && $model->validate()) {
    //         if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
    //             Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
    //         } else {
    //             Yii::$app->session->setFlash('error', 'There was an error sending your message.');
    //         }

    //         return $this->refresh();
    //     } else {
    //         return $this->render('contact', [
    //             'model' => $model,
    //         ]);
    //     }
    // }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    
                    $session = Yii::$app->session;
                    $session->set('user',$this->getUser());
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
