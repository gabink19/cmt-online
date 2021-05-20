<?php

namespace backend\controllers;

use Yii;
use backend\models\Persetujuan;
use backend\models\User;
use backend\models\Notifikasi;
use backend\models\PersetujuanSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Pendaftaran;
use yii\helpers\Url;

/**
 * PersetujuanController implements the CRUD actions for Persetujuan model.
 */
class PersetujuanController extends MainController 
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Persetujuan models.
     * @return mixed
     */
    public function actionIndex()
    {
        $params = Yii::$app->request->queryParams;

        $searchModel = new PersetujuanSearch();
        $dataProvider = $searchModel->search($params);

        if(isset($_GET['PersetujuanSearch'])){
            $searchModel->start_periode = $_GET['PersetujuanSearch']['start_periode'];
            $searchModel->stop_periode = $_GET['PersetujuanSearch']['stop_periode'];
            $searchModel->tujuan = $_GET['PersetujuanSearch']['tujuan'];

        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Persetujuan model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    // public function actionHbd()
    // {
    // 	$html = file_get_contents('/home/developt/web-cmt-online/cmt-online/backend/web/hbd.html');
    // 	// echo $html;die();
    // 	// echo "<pre>"; print_r(glob('/home/developt/web-cmt-online/cmt-online/backend/web/*'));echo "</pre>";die();
    // 	Yii::$app->mailer->compose()
    //         ->setTo('gibran1905@gmail.com')
    //         ->setFrom([ 'gibran@gmail.com' => 'Happy Birthday De' ])
    //         ->setSubject('Happy Birthday De Dien')
    //         ->setHtmlBody($html)
    //         ->send();
    // }

    public function actionImport($value='')
    {
        $file = file_get_contents('/home/developt/web-cmt-online/cmt-online/backend/importfile/tindakanFix.csv');
        // $file = str_replace('pdf'.'\r', 'pdf'.PHP_EOL, $file);
        $array1 = explode(PHP_EOL, $file);
        // echo "<pre>"; print_r($array1);echo "</pre>";die();
        foreach ($array1 as $key => $value) {
            if ($key!=0) {
                $array2 = explode(';',$value);
                $model = new Persetujuan();
                $model->tpt_uniq_code = uniqid();
                $model->tpt_tp_nikes = $array2[0];
                $model->tpt_td_id = Pendaftaran::find()->select(['td_id'])->where(['=','td_tp_nikes', $array2[0]])->andWhere(['=','td_tgl_daftar', $array2[2]])->one();
                echo "<pre>"; print_r($model->attributes);echo "</pre>";die();
                // [tpt_td_id] => 147
                // [tpt_catatan_mitra] => tes
                // [tpt_path_permintaan_tindak] => /home/developt/web-cmt-online/cmt-online/public/uploadPermintaan/2020/03/460749.000_2020-03-10_09:47:32.100_historypengobatan
                // [tpt_flag_status] => 0
                // [tpt_id_user_backend] => 172
                // [tpt_catatan_yakes] => Mantap Mantap
                // [tpt_id_user_frontend] => 184
                // [tpt_nama_mitra] => RS PREMIER JATINEGARA
                // [tpt_nama_user_backend] => 
                // [tgl_permintaan] => 2020-03-10 09:47:32
                // [tgl_persetujuan] => 2020-03-18 16:20:59
                // [first_ip_backend] => 
                // [last_ip_backend] => 182.253.170.86
                // [first_ip_frontend] => 125.166.79.220
                // [last_ip_frontend] => 
                // [first_date_backend] => 
                // [last_date_backend] => 2020-03-18 16:20:59
                // [first_date_frontend] => 2020-03-10 09:47:32
                // [last_date_frontend] => 
                // [first_user_backend] => 
                // [last_user_backend] => admin
                // [first_user_frontend] => mitra1b
                // [last_user_frontend] => 
                // [flag_deleted] => 0
                // [tpt_diagnosa] => 42
                // [history_note] => 
                // [biaya] => 100
                // [biaya_disetujui] => 100
            }
        }
        echo "<pre>"; print_r($array1);echo "</pre>";die();
    }

    public function uploadFile($tempName,$fileName,$nikes='') 
    {
        $explodeFile = explode('.',$fileName);
        $fileName = $nikes.'_'.date("Y-m-d_H:i:s").'.'.end($explodeFile);
        // shell_exec('chmod 777 -R '.Yii::$app->params['pathPermintaan']);
        // chmod(Yii::$app->params['pathPermintaan'], 0777);
        // echo "<pre>"; print_r(getcwd());echo "</pre>";die();
        if (!move_uploaded_file($tempName, Yii::$app->params['pathPermintaan'] . $fileName)) {
            return '';
        }
        return Yii::$app->params['pathPermintaan'] .$fileName;
    }

    public function actionTujuan($id='0')
    {
        $model = Pendaftaran::findOne($id);
        $array = [''=>'',0=>'Rawat Jalan', 1=>'Rawat Inap'];
        if (isset($model->td_tujuan)) {
            return $array[$model->td_tujuan];
        }else{
            return '';
        }
    }

    public function actionDownload($filename)
    {
        // $filename = 'Test.pdf'; // of course find the exact filename....        
        header('Pragma: public');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Cache-Control: private', false); // required for certain browsers 
        header('Content-Type: application/pdf');

        header('Content-Disposition: attachment; filename="'. basename($filename) . '";');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . filesize($filename));

        readfile($filename);

        exit;
    }

    public function actionViewpdf($filename)
    {
       	header("Content-type: application/pdf");
		header("Content-Disposition: inline; filename=".basename($filename));
		header("Content-Length: ".filesize($filename));
		readfile($filename);
        exit;
    }
    /**
     * Creates a new Persetujuan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        throw new NotFoundHttpException('The requested page does not exist.');
        $model = new Persetujuan();
        $model->scenario = 'create';

        if ($model->load(Yii::$app->request->post())){
            $name = $_FILES['Persetujuan']['name']['tpt_path_permintaan_tindak'];
            $tmp_name = $_FILES['Persetujuan']['tmp_name']['tpt_path_permintaan_tindak'];
            $size = number_format($_FILES['Persetujuan']['size']['tpt_path_permintaan_tindak'] / 1048576, 2);
            $fileExplode = explode('.', $name);
            $fileExtensions = $fileExplode[count($fileExplode)-1];
            if (strtolower($fileExtensions) =='pdf' && $size <= 3) {
                $model->tpt_path_permintaan_tindak = $this->uploadFile($tmp_name,$name,$model->tpt_tp_nikes);
                if ($model->validate()) {
                    $model->first_user_frontend =$this->userSelf();
                    $model->first_ip_frontend  = $_SERVER['REMOTE_ADDR'];
                    $model->first_date_frontend = date('Y-m-d H:i:s');
                    $model->tgl_permintaan = $model->tgl_permintaan.date(' H:i:s');
                    if($model->save()) {
                        $attributes = $model->attributeLabels();
                        $data = "";
                        foreach ($model as $key => $value) {
                            $data .= $attributes[$key].":".$model->$key.",";
                        }
                        $activity = "[CREATE PERSETUJUAN] ".$data;
                        $this->historyUser($activity,$user,$ip);
                        Yii::$app->session->set('notif','Create Persetujuan');
                        // return $this->redirect(['view', 'id' => $model->tpt_id]);
                        
                        if (isset($_GET['FlagMobile']) && $_GET['FlagMobile']=='true' && isset($_GET['IdUser']) && $_GET['IdUser']!='') {
                            return $this->redirect(['index','FlagMobile'=>'true','IdUser'=>$_GET['IdUser']]);
                        }else{
                            return $this->redirect(['index']);
                        }
                    }
                }
            }else{
                $model->addError('tpt_path_permintaan_tindak', 'File Harus berformat PDF & Max. 2MB');
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Persetujuan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelOld = $this->findModel($id);
        $url = 'persetujuan%2Fupdate&id='.$id;

        $query = 'UPDATE tbl_notifikasi SET tn_telah_dibaca="1",tn_dibaca_tanggal="'.date('Y-m-d H:i:s').'" WHERE tn_type_notif="0" AND tn_telah_dikirim="1" AND tn_telah_dibaca="0" AND flag_deleted="0" AND tn_link LIKE "%'.$url.'%"' ;
        $result = Yii::$app->db->createCommand($query)->execute();

        if ($model->load(Yii::$app->request->post())){
            $session = Yii::$app->session;
            $user = $session->get('user');
            if ($model->validate()) {
                $model->tgl_persetujuan = date('Y-m-d H:i:s');
                $model->tpt_id_user_backend = @$user->id;
                $model->last_user_backend =@$user->username;
                $model->last_ip_backend  = $_SERVER['REMOTE_ADDR'];
                $model->last_date_backend = date('Y-m-d H:i:s');
                $model->biaya_disetujui = str_replace('.', '', $model->biaya_disetujui);
                $model->biaya = str_replace('.', '', $model->biaya);
                // echo "<pre>"; print_r($model);echo "</pre>";die();
                if($model->save()) {

                    $query = 'UPDATE tbl_daftar SET td_flag_status="3" WHERE td_id = "'.$model->tpt_td_id.'" AND td_tp_nikes="'.$model->tpt_tp_nikes.'" AND flag_deleted="0"' ;
                    $result = Yii::$app->db->createCommand($query)->execute();

                    $attributes = $model->attributeLabels();
                    $data = '';
                    foreach ($model as $key => $value) {
                        if ($modelOld[$key]!=$model->$key) {
                            $data .= $attributes[$key].":".$modelOld[$key]." to ".$model->$key.",";
                        }
                    }
                    $user = Yii::$app->user->identity->username;
                    $ip = $_SERVER['REMOTE_ADDR'];
                    $activity = "[UPDATE PERSETUJUAN ID : ".$id."] ".$data;
                    $this->historyUser($activity,$user,$ip);

                    $modelNotif = new Notifikasi();
                    $modelNotif->tn_user_mitra = $model->tpt_id_user_frontend;
                    $modelNotif->tn_tanggal = date('Y-m-d H:i:s');
                    $modelNotif->tn_judul = 'Keputusan Tindak ('.Yii::$app->params['tujuan'][Pendaftaran::findOne($model->tpt_td_id)->td_tujuan].')';
                    $modelNotif->tn_teks = 'Permintaan Tindak pada nikes '.$model->tpt_tp_nikes.' : '. @Yii::$app->params['persetujuan'][$model->tpt_flag_status];
                    $modelNotif->tn_type_notif = 1;
                    $modelNotif->tn_telah_dikirim = 1;
                    $modelNotif->tn_telah_dibaca = 0;
                    $modelNotif->tn_jenis_kegiatan = 2;
                    $modelNotif->tn_link = str_replace('/backend', '/', Url::to(['persetujuan/view', 'id' => $model->tpt_id]));
                    $modelNotif->tn_user_id = Yii::$app->user->id;
                    $modelNotif->tn_type_rawat = Pendaftaran::findOne($model->tpt_td_id)->td_tujuan;
                    $modelNotif->save(false);
                    if ($model->tpt_flag_status==1) {
                       $name = 'email_ke_frontend_gagal';
                    }else{
                       $name = 'email_ke_frontend_sukses';
                    }
                    $getTemplate = 'SELECT * FROM tbl_global_parameter where name="'.$name.'" LIMIT 1';
                    $getTemplate = Yii::$app->db->createCommand($getTemplate)->queryOne();
                    $from = $getTemplate['from'];
                    $body = $getTemplate['value'];
                    $user = User::findOne($model->tpt_id_user_frontend);
                    $to = $user->email;

                    $daftar = Pendaftaran::findOne($model->tpt_td_id);
                    $body = str_replace('[nikes]', $model->tpt_tp_nikes, $body);
                    $body = str_replace('[nama]', $daftar->td_nama_kel, $body);
                    $body = str_replace('[catatan_yakes]', $model->tpt_catatan_yakes, $body);
                    $url = str_replace('//', '/', $_SERVER['HTTP_HOST'].$modelNotif->tn_link);
                    $body = str_replace('[link]', '<a href="'.$url.'">'.$url.'</a>', $body);
                    $subject = 'Laporan Persetujuan Tindakan nikes : '.$model->tpt_tp_nikes.'(TESTING)';
                    $this->SendEmail($to,$from,$subject,$body);
                    // echo "<pre>"; print_r($getTemplate);echo "</pre>";die();
                    Yii::$app->session->set('notif','Update Persetujuan');
                    // return $this->redirect(['view', 'id' => $model->tpt_id]);
                    
                    if (isset($_GET['FlagMobile']) && $_GET['FlagMobile']=='true' && isset($_GET['IdUser']) && $_GET['IdUser']!='') {
                        return $this->redirect(['index','FlagMobile'=>'true','IdUser'=>$_GET['IdUser']]);
                    }else{
                        return $this->redirect(['index']);
                    }
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Persetujuan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->flag_deleted = 1;
         // ->delete();
        if($model->save(false)) { 
            $attributes = $model->attributeLabels();
            $data = "";
            foreach ($model as $key => $value) {
                $data .= $attributes[$key].":".$model->$key.",";
            }
            $activity = "[DELETE PERSETUJUAN] ".$data;
            $this->historyUser($activity,$user,$ip);
            Yii::$app->session->set('notif','Hapus Persetujuan');
            if (isset($_GET['FlagMobile']) && $_GET['FlagMobile']=='true' && isset($_GET['IdUser']) && $_GET['IdUser']!='') {
                return $this->redirect(['index','FlagMobile'=>'true','IdUser'=>$_GET['IdUser']]);
            }else{
                return $this->redirect(['index']);
            }
        }
    }


    /**
     * Finds the Persetujuan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Persetujuan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Persetujuan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
