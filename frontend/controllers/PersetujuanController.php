<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Persetujuan;
use frontend\models\PersetujuanSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\models\Pendaftaran;
use frontend\models\Notifikasi;
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
        $url = Url::to(['persetujuan/view', 'id' => $id]);
        $query = 'UPDATE tbl_notifikasi SET tn_telah_dibaca="1",tn_dibaca_tanggal="'.date('Y-m-d H:i:s').'" WHERE tn_type_notif="1" AND tn_telah_dikirim="1" AND tn_telah_dibaca="0" AND flag_deleted="0" AND tn_link LIKE "%'.$url.'%"' ;
        $result = Yii::$app->db->createCommand($query)->execute();
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
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

    public function actionRekmedis($id='0')
    {
        $query = 'SELECT td_id FROM tbl_daftar WHERE td_tp_nikes="'.$id.'" ORDER BY td_id DESC';
        $result = Yii::$app->db->createCommand($query)->queryScalar();
        return $result;
    }
    /**
     * Creates a new Persetujuan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Persetujuan();
        $model->scenario = 'create';

        if ($model->load(Yii::$app->request->post())){
            $name = $_FILES['Persetujuan']['name']['tpt_path_permintaan_tindak'];
            $tmp_name = $_FILES['Persetujuan']['tmp_name']['tpt_path_permintaan_tindak'];
            $size = number_format($_FILES['Persetujuan']['size']['tpt_path_permintaan_tindak'] / 1048576, 2);
            $fileExplode = explode('.', $name);
            $fileExtensions = $fileExplode[count($fileExplode)-1];
            $data = 'SELECT count(*) FROM tbl_daftar WHERE td_tp_nikes="'.$model->tpt_tp_nikes.'" order by td_id LIMIT 1';
            $result = Yii::$app->db->createCommand($data)->queryScalar();
            if ($result>0) {
                if (strtolower($fileExtensions) =='pdf' && $size <= 3) {
                    $model->tpt_path_permintaan_tindak = $this->uploadFile($tmp_name,$name,$model->tpt_tp_nikes);
                    if ($model->validate()) {

                        $session = Yii::$app->session;
                        $user = $session->get('user');
                        $model->tpt_id_user_frontend  = @$user->id;
                        $model->tpt_nama_mitra  = Yii::$app->user->identity->rs_mitra;
                        $model->first_user_frontend = @$user->username;
                        $model->first_ip_frontend  = $_SERVER['REMOTE_ADDR'];
                        $model->first_date_frontend = date('Y-m-d H:i:s');
                        $model->tgl_permintaan = date('Y-m-d H:i:s');
                        if($model->save()) {

                            $query = 'UPDATE tbl_daftar SET td_flag_status="2" WHERE td_id = "'.$model->tpt_td_id.'" AND td_tp_nikes="'.$model->tpt_tp_nikes.'" AND flag_deleted="0"' ;
                            $result = Yii::$app->db->createCommand($query)->execute();

                            $modelNotif = new Notifikasi();
                            $modelNotif->tn_kepada = 6;
                            $modelNotif->tn_tanggal = date('Y-m-d H:i:s');
                            $modelNotif->tn_judul = 'Permintaan Tindak';
                            $modelNotif->tn_teks = 'Permintaan Tindak pada nikes '.$model->tpt_tp_nikes.'.';
                            $modelNotif->tn_type_notif = 0;
                            $modelNotif->tn_telah_dikirim = 1;
                            $modelNotif->tn_telah_dibaca = 0;
                            $modelNotif->tn_jenis_kegiatan = 2;
                            $modelNotif->tn_link = str_replace('frontend', 'backend', Url::to(['persetujuan/update', 'id' => $model->tpt_id]));
                            $modelNotif->tn_user_id = Yii::$app->user->id;
                            $modelNotif->save(false);
                             $attributes = $model->attributeLabels();
                            $data = "";
                            foreach ($model as $key => $value) {
                                $data .= $attributes[$key].":".$model->$key.",";
                            }
                            $activity = "[CREATE DAFTAR PASIEN/PERSETUJUAN] ".$data;
                            $this->historyUser($activity,$user,$ip);
                            Yii::$app->session->set('notif','Create Persetujuan');
                            // return $this->redirect(['view', 'id' => $model->tpt_id]);
                            return $this->redirect(['index']);
                        }else{
                        // echo "<pre>"; print_r($model->getErrors());echo "</pre>";
                    }
                    }else{
                        // echo "<pre>"; print_r($model->getErrors());echo "</pre>";
                    }
                }else{
                    $model->addError('tpt_path_permintaan_tindak', 'File Harus berformat PDF & Max. 2MB');
                }
            }else{
                $model->addError('tpt_tp_nikes', 'Nikes Belum Melakukan Pendaftaran');
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

        if ($model->load(Yii::$app->request->post())){
            $session = Yii::$app->session;
            $user = $session->get('user');
            if ($_FILES['Persetujuan']['name']['tpt_path_permintaan_tindak']=='') {
                $model->tpt_path_permintaan_tindak=$modelOld->tpt_path_permintaan_tindak;
                if ($model->validate()) {
                    $model->last_user_frontend =@$user->username;
                    $model->last_ip_frontend  = $_SERVER['REMOTE_ADDR'];
                    $model->last_date_frontend = date('Y-m-d H:i:s');
                    $model->biaya = str_replace('.', '', $model->biaya);
                    if($model->save()) {
                         $attributes = $model->attributeLabels();
                        $data = '';
                        foreach ($model as $key => $value) {
                            if ($modelOld[$key]!=$model->$key) {
                                $data .= $attributes[$key].":".$modelOld[$key]." to ".$model->$key.",";
                            }
                        }
                        $user = Yii::$app->user->identity->username;
                        $ip = $_SERVER['REMOTE_ADDR'];
                        $activity = "[UPDATE DAFTAR PASIEN/PERSETUJUAN ID : ".$id."] ".$data;
                        $this->historyUser($activity,$user,$ip);
                        Yii::$app->session->set('notif','Update Persetujuan');
                        // return $this->redirect(['view', 'id' => $model->tpt_id]);
                        return $this->redirect(['index']);
                    }
                }
            }else{
                $name = $_FILES['Persetujuan']['name']['tpt_path_permintaan_tindak'];
                $tmp_name = $_FILES['Persetujuan']['tmp_name']['tpt_path_permintaan_tindak'];
                $fileExplode = explode('.', $name);
                $fileExtensions = $fileExplode[count($fileExplode)-1];
                if (strtolower($fileExtensions) =='pdf') {
                    $model->tpt_path_permintaan_tindak = $this->uploadFile($tmp_name,$name,$model->tpt_tp_nikes);
                    if ($model->validate()) {
                        $model->last_user_frontend =@$user->username;
                        $model->last_ip_frontend  = $_SERVER['REMOTE_ADDR'];
                        $model->last_date_frontend = date('Y-m-d H:i:s');
                        $model->biaya = str_replace('.', '', $model->biaya);
                        if($model->save()) {
                             $attributes = $model->attributeLabels();
                        $data = '';
                        foreach ($model as $key => $value) {
                            if ($modelOld[$key]!=$model->$key) {
                                $data .= $attributes[$key].":".$modelOld[$key]." to ".$model->$key.",";
                            }
                        }
                        $user = Yii::$app->user->identity->username;
                        $ip = $_SERVER['REMOTE_ADDR'];
                        $activity = "[UPDATE DAFTAR PASIEN/PERSETUJUAN ID : ".$id."] ".$data;
                        $this->historyUser($activity,$user,$ip);
                        Yii::$app->session->set('notif','Update Persetujuan');
                            // return $this->redirect(['view', 'id' => $model->tpt_id]);
                        return $this->redirect(['index']);
                        }
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
            $activity = "[DELETE DAFTAR PASIEN/PERSETUJUAN] ".$data;
            $this->historyUser($activity,$user,$ip);
            Yii::$app->session->set('notif','Delete Persetujuan');
            return $this->redirect(['index']);
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
