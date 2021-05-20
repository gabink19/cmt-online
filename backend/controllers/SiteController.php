<?php
namespace backend\controllers;

use Yii;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use backend\models\Menu;
use backend\models\User;
use backend\models\Chat;
use backend\models\Rujukan;
use backend\models\UserSearch;

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
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
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

    public function actionInfo()
    {
        echo phpinfo();
        die();
    }


    public function actionRelog()
    {
        return $this->render('relog');
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
        ];
    }
     public function actionCheckNotif($link)
    {
        $query = 'SELECT * FROM tbl_notifikasi WHERE tn_link like "%'.$link.'%" AND tn_type_notif="0" AND tn_telah_dikirim="1" AND tn_telah_dibaca="0" AND flag_deleted="0"' ;
        $result['data'] = Yii::$app->db->createCommand($query)->queryAll();
        if (!empty($result['data'])) {
          foreach ($result['data'] as $key => $value) {
            if (!strrpos($value['tn_link'], '/backend')) {
                $value['tn_link'] = '/backend'.$value['tn_link'];
            }
              $result['data'][$key]['tn_link']=str_replace('/frontend', '', $value['tn_link']);
          }
        }
        $result['jumlah'] = count($result['data']);
        return json_encode($result);
    }
    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $session = Yii::$app->session;
        $user = $session->get('user');
        if(Yii::$app->user->isGuest) {
            Yii::$app->user->logout();
            return $this->redirect(['site/login']);
        }
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
        // echo "<pre>"; print_r(Yii::$app->request->post());echo "</pre>";die();
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $this->historyUser('[LOGIN]',$user,$ip);
            // return $this->goBack();
        	return $this->redirect(['persetujuan/index']);
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
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

    public function actionSendchat()
    {
        if ($_POST) {
            $model = new Chat();
            $model->userId = $_POST['id'];
            $model->message = $_POST['pesan'];
            $model->idroom = $_POST['room'];
            $model->updateDate = date('Y-m-d H:i:s');
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
    public function actionPdf()
    {
        return $this->render('pdf');
    }
    public function actionSendfile()
    {
        // echo "<pre>"; print_r($_SERVER);echo "</pre>";;die();
        if ($_GET) {
            $model = new Chat();
            $model->userId = $_GET['id'];
            $model->idroom = $_GET['room'];
            $model->updateDate = date('Y-m-d H:i:s');
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
        $query = "SELECT id,username from user where type_user<>'".$type_user."' order by username asc";
        $command = Yii::$app->db->createCommand($query)->queryAll();
        $array = [];
        $no = 0;
        foreach ($command as $key => $value) {
            $array[$no]['id'] = $value['id'];
            $array[$no]['username'] = $value['username'];
            $query = "SELECT count(*) as total from chat where ((idroom='".$id."_".$value['id']."') or (idroom='".$value['id']."_".$id."')) and status_read<>1 order by updateDate asc";
            $nilai = Yii::$app->db->createCommand($query)->queryScalar();
            if ($nilai>0) {
                $array[$no]['status_read'] = 1;
            }else{
                $array[$no]['status_read'] = 0;
            }
            $no++;
        }

        return json_encode($array);
    }
    public function actionGetchat()
    {
        $room = $_POST['room'];
        $exp = explode('_', $room);
        $exp1 = $exp[0];
        $exp2 = $exp[1];
        $query = "SELECT id,userId,updateDate,message,path,status_read from chat where ((idroom='".$exp1."_".$exp2."') or (idroom='".$exp2."_".$exp1."')) order by updateDate asc";
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
                $array[] = ['userId'=>$value['userId'],'id'=>$value['id'],'message'=>$message,'updateDate'=>$date,'nama'=>$nama->username,'status_read'=>$value['status_read']];
            }else{
                $array[] = ['userId'=>$value['userId'],'id'=>$value['id'],'message'=>$value['message'],'updateDate'=>$date,'nama'=>$nama->username,'status_read'=>$value['status_read']];
            }
        }
        return json_encode($array);
    }
    public function actionChecknew($lastid,$idroom,$user)
    {
        $exp = explode('_', $idroom);
        $exp1 = $exp[0];
        $exp2 = $exp[1];
        $query = "SELECT id from chat where ((idroom='".$exp1."_".$exp2."') or (idroom='".$exp2."_".$exp1."')) and userId <> $user order by updateDate desc LIMIT 1";
        $idquery = Yii::$app->db->createCommand($query)->queryScalar();
        if ($idquery!=$lastid) {
            $query = "SELECT id,userId,updateDate,message,path from chat where id=$idquery order by updateDate asc";
            $command = Yii::$app->db->createCommand($query)->queryAll();
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
                    $ext = explode('.', end($expoder));
                    $message = '<a href="'.Url::to(['download'])."&filename=".$value['path'].'" target="_blank">'.end($expoder).'</a>';
                    // $array[] = ['id'=>$value['id'],'userId'=>$value['userId'],'message'=>$message,'updateDate'=>$date,'nama'=>$nama->username];
                    if (end($ext)=='jpg'||end($ext)=='jpeg'||end($ext)=='png') {
                        $message = '<a href="'.Url::to(['download'])."&filename=".$value['path'].'" target="_blank"><img src="'.Url::to(['download'])."&filename=".$value['path'].'" width="200px"></a>';
                    }else{
                        $message = '<a href="'.Url::to(['download'])."&filename=".$value['path'].'" target="_blank">'.end($expoder).'</a>';
                    }
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
}
