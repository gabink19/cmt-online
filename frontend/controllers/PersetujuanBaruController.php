<?php

namespace frontend\controllers;

use Yii;
use frontend\models\PersetujuanBaru;
use frontend\models\PersetujuanBaruSearch;
use frontend\models\PendaftaranSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\models\Pendaftaran;
use frontend\models\Notifikasi;
use yii\helpers\Url;

/**
 * PersetujuanController implements the CRUD actions for Persetujuan model.
 */
class PersetujuanBaruController extends MainController 
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
     * Lists all PersetujuanBaru models.
     * @return mixed
     */
    public function actionIndex()
    {
        $params = Yii::$app->request->queryParams;
        // $params['PendaftaranSearch']['td_flag_status'] = 1;
        // echo "<pre>"; print_r($params);echo "</pre>";
        $searchModel = new PendaftaranSearch();
        $dataProvider = $searchModel->searchPersetujuan($params);

        $searchModel->start_periode = isset($_GET['PendaftaranSearch'])?$_GET['PendaftaranSearch']['start_periode']:null;
        $searchModel->stop_periode = isset($_GET['PendaftaranSearch'])?$_GET['PendaftaranSearch']['stop_periode']:null;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionDiagnosa($q = null, $id = null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        $newarray = [];
        if (!is_null($q)) {
            $query = 'SELECT tdg_id as id, tdg_penamaan as nama, tdg_kode as kode FROM tbl_diagnosa WHERE (tdg_penamaan like "%'.$q.'%") OR (tdg_kode like "%'.$q.'%") LIMIT 30';
            $command = Yii::$app->db->createCommand($query);
            $data = $command->queryAll();
            foreach ($data as $key => $value) {
                $newarray[$key]['id'] =$value['id'];
                $newarray[$key]['text'] = $value['kode'] ." - ".$value['nama'];
            }
            $out['results'] = array_values($newarray);
        }
        elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => $id];
        }
        return $out;
    }

    /**
     * Displays a single PersetujuanBaru model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = Pendaftaran::findOne($id);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function uploadFile($tempName,$fileName,$nikes='') 
    {
        $explodeFile = explode('.',$fileName);
        $fileName = $nikes.'_'.date("Y-m-d_H:i:s").'.'.end($explodeFile);
        // shell_exec('chmod 777 -R '.Yii::$app->params['pathPermintaan']);
        // chmod(Yii::$app->params['pathPermintaan'], 0777);
        if (!move_uploaded_file($tempName, Yii::$app->params['pathPermintaan'].date('Y').'/'.date('m').'/'. $fileName)) {
            // echo "<pre>"; print_r(getcwd());echo "</pre>";die();
            return '';
        }
        return Yii::$app->params['pathPermintaan'] .date('Y').'/'.date('m').'/'.$fileName;
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
     * Creates a new PersetujuanBaru model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id,$nikes,$uniq_code='')
    {
        $model = new PersetujuanBaru();
        $model->scenario = 'create';
        if ($model->load(Yii::$app->request->post())){
            $name = $_FILES['PersetujuanBaru']['name']['tpt_path_permintaan_tindak'];
            $tmp_name = $_FILES['PersetujuanBaru']['tmp_name']['tpt_path_permintaan_tindak'];
            $size = number_format($_FILES['PersetujuanBaru']['size']['tpt_path_permintaan_tindak'] / 1048576, 2);
            $fileExplode = explode('.', $name);
            $fileExtensions = $fileExplode[count($fileExplode)-1];
            if (strtolower($fileExtensions) =='pdf' && $size <= 3) {
                $model->tpt_path_permintaan_tindak = $this->uploadFile($tmp_name,$name,$model->tpt_tp_nikes);
                if ($model->validate()) {

                    $session = Yii::$app->session;
                    $user = $session->get('user');
                    if ($model->tpt_uniq_code=='') {
                        $model->tpt_uniq_code = uniqid();
                    }
                    $model->tpt_id_user_frontend  = @$user->id;
                    $model->tpt_nama_mitra  = Yii::$app->user->identity->rs_mitra;
                    $model->first_user_frontend = @$user->username;
                    $model->first_ip_frontend  = $_SERVER['REMOTE_ADDR'];
                    $model->first_date_frontend = date('Y-m-d H:i:s');
                    $model->tgl_permintaan = date('Y-m-d H:i:s');
                    $model->biaya = str_replace('.', '', $model->biaya);
                    if($model->save()) {
                        $query = 'UPDATE tbl_daftar SET td_flag_status="2" WHERE td_id = "'.$model->tpt_td_id.'" AND td_tp_nikes="'.$model->tpt_tp_nikes.'" AND flag_deleted="0"' ;
                        $result = Yii::$app->db->createCommand($query)->execute();
                        $modelNotif = new Notifikasi();
                        $modelNotif->tn_kepada = 6;
                        $modelNotif->tn_tanggal = date('Y-m-d H:i:s');
                        $modelNotif->tn_judul = 'Permintaan Tindak ('.Yii::$app->params['tujuan'][Pendaftaran::findOne($model->tpt_td_id)->td_tujuan].')';
                        $modelNotif->tn_teks = 'Permintaan Tindak pada nikes '.$model->tpt_tp_nikes.'.';
                        $modelNotif->tn_type_notif = 0;
                        $modelNotif->tn_telah_dikirim = 1;
                        $modelNotif->tn_telah_dibaca = 0;
                        $modelNotif->tn_jenis_kegiatan = 2;
                        $modelNotif->tn_link = str_replace('frontend', 'backend', Url::to(['persetujuan/update', 'id' => $model->tpt_id]));
                        $modelNotif->tn_user_id = Yii::$app->user->id;
                        $modelNotif->tn_type_rawat = Pendaftaran::findOne($model->tpt_td_id)->td_tujuan;
                        $modelNotif->save(false);

                        $getTemplate = 'SELECT * FROM tbl_global_parameter where name="email_ke_backend" LIMIT 1';
                        $getTemplate = Yii::$app->db->createCommand($getTemplate)->queryOne();
                        $to = $getTemplate['to'];
                        $from = $getTemplate['from'];
                        $body = $getTemplate['value'];

                        $daftar = Pendaftaran::findOne($model->tpt_td_id);
                        $body = str_replace('[nikes]', $model->tpt_tp_nikes, $body);
                        $body = str_replace('[nama_pasien]', $daftar->td_nama_kel, $body);
                        $body = str_replace('[nama_karyawan]', $daftar->td_tp_nama_kk, $body);
                        $body = str_replace('[mitra_rs]', $model->tpt_nama_mitra, $body);
                        $body = str_replace('[hak_kelas]', $daftar->td_hak_kelas, $body);
                        $body = str_replace('[catatan_mitra]', $model->tpt_catatan_mitra, $body);
                        $url = str_replace('//', '/', $_SERVER['HTTP_HOST'].'/backend/'.$modelNotif->tn_link);
                        $url = str_replace('///', '/', $url);
                        $body = str_replace('[link]', '<a href="'.$url.'">'.$url.'</a>', $body);
                        $body = str_replace('Nominal : [nominal]', '', $body);
                        $subject = 'Persetujuan Tindakan nikes : '.$model->tpt_tp_nikes.' '.date('Y-m-d H:i:s').' (TESTING)';
                        $attach = $model->tpt_path_permintaan_tindak;
                        // echo "<pre>"; print_r($getTemplate);echo "</pre>";die();
                        $this->SendEmail($to,$from,$subject,$body,$attach);
                        $attributes = $model->attributeLabels();
                        $data = "";
                        foreach ($model as $key => $value) {
                            $data .= $attributes[$key].":".$model->$key.",";
                        }
                        $activity = "[CREATE DAFTAR PASIEN/PERSETUJUAN] ".$data;
                        $this->historyUser($activity,$user,$ip);

                        Yii::$app->session->set('notif','Create Persetujuan');
                        // return $this->redirect(['persetujuan/view', 'id' => $model->tpt_id]);
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
        }
        if ($uniq_code != '') {
            $model = PersetujuanBaru::find()
                    ->where(['tpt_uniq_code' => $uniq_code])
                    ->one();
            $q = 'select tdg_penamaan from tbl_diagnosa where tdg_id='.$model->tpt_diagnosa;
            $d = Yii::$app->db->createCommand($q)->queryScalar();
            $model->tpt_id = '';
            $model->diagnosa = $d;
            $model->tpt_catatan_mitra = '';

            $q = 'select tpt_catatan_mitra,tpt_catatan_yakes,tgl_permintaan,tgl_persetujuan from tbl_persetujuan_tindak where tpt_uniq_code="'.$uniq_code.'"';
            $d = Yii::$app->db->createCommand($q)->queryAll();

            $history_catatan = '';
            foreach ($d as $key => $value) {
                $history_catatan .= $value['tgl_permintaan'];
                $history_catatan .= " Catatan Mitra : ".$value['tpt_catatan_mitra']."\n\n";
                $history_catatan .= $value['tgl_persetujuan'];
                $history_catatan .= " Catatan Yakes : ".$value['tpt_catatan_yakes']."\n\n";
            }


            $model->history_catatan = $history_catatan;
            return $this->render('create', [
                'model' => $model,
            ]);
            // echo "<pre>"; print_r($model);echo "</pre>";die();
        }else{
            $model->tpt_tp_nikes = $nikes;
            $model->tpt_td_id = $id;
        }
        // echo "<pre>"; print_r($model);echo "</pre>";die();
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing PersetujuanBaru model.
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
            if ($_FILES['PersetujuanBaru']['name']['tpt_path_permintaan_tindak']=='') {
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
                $name = $_FILES['PersetujuanBaru']['name']['tpt_path_permintaan_tindak'];
                $tmp_name = $_FILES['PersetujuanBaru']['tmp_name']['tpt_path_permintaan_tindak'];
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
     * Deletes an existing PersetujuanBaru model.
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
     * Finds the PersetujuanBaru model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PersetujuanBaru the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PersetujuanBaru::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
