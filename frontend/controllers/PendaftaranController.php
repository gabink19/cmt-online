<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Pendaftaran;
use frontend\models\PendaftaranSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\models\Peserta;
use frontend\models\Notifikasi;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/**
 * PendaftaranController implements the CRUD actions for Pendaftaran model.
 */
class PendaftaranController extends MainController 
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
     * Lists all Pendaftaran models.
     * @return mixed
     */
    public function actionIndex()
    {
       $params = Yii::$app->request->queryParams;

        $searchModel = new PendaftaranSearch();
        $dataProvider = $searchModel->search($params);

        $searchModel->start_periode = isset($_GET['PendaftaranSearch'])?$_GET['PendaftaranSearch']['start_periode']:null;
        $searchModel->stop_periode = isset($_GET['PendaftaranSearch'])?$_GET['PendaftaranSearch']['stop_periode']:null;

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Pendaftaran model.
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
    public function actionSelect($q = null, $id = null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = 'SELECT tp_nikes as id, tp_nikes as text FROM tbl_peserta WHERE tp_nikes like "%'.$q.'%" LIMIT 10';
            $command = Yii::$app->db->createCommand($query);
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        }
        elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => $id];
        }
        return $out;
    }
    public function uploadFile($tempName,$fileName,$td_tp_nikes) 
    {
        $explodeFile = explode('.',$fileName);
        $fileName = $td_tp_nikes.'_'.date("Y-m-d_H:i:s").'.'.end($explodeFile);
        // shell_exec('chmod 777 -R '.Yii::$app->params['pathPermintaan']);
        // chmod(Yii::$app->params['pathPermintaan'], 0777);
        // echo "<pre>"; print_r(getcwd());echo "</pre>";die();
        if (!move_uploaded_file($tempName, Yii::$app->params['pathPendaftaran'] .date('Y').'/'.date('m').'/'. $fileName)) {
            return '';
        }
        return Yii::$app->params['pathPendaftaran'] .date('Y').'/'.date('m').'/'. $fileName;
    }

    public function actionPeserta($td_tp_nikes)
    {

        $session = Yii::$app->session;
        $user = $session->get('user');
    	$band =  ArrayHelper::map($session->get('band'), 'tbp_id', 'tbp_penamaan');

        $data = 'SELECT * FROM tbl_peserta WHERE tp_nikes="'.$td_tp_nikes.'"';
        $result = Yii::$app->db->createCommand($data)->queryOne();
        if ($band[$result['tp_band_posisi']] != '' && (($result['kategori_host']==1 && $result['tp_tgl_pens'] > '2004-08-01') || ($result['kategori_host']==2))) {
            if (strpos($band[$result['tp_band_posisi']], '.') !== false) {
                $band_posisi = explode('.', $band[$result['tp_band_posisi']])[0];
            }else{
                $band_posisi = $band[$result['tp_band_posisi']];
            }
            // echo "<pre>"; print_r($band[$result['tp_band_posisi']]);echo "</pre>";die();
            $data = 'SELECT `'.$band_posisi.'` FROM tbl_hak_kelas WHERE thk_rumah_sakit="'.$user->rs_mitra.'" and thk_kategori_host="PEGAWAI" and flag_active=0';
            $result1 = Yii::$app->db->createCommand($data)->queryScalar();
            $result['hak_kelas'] = $result1;
            $result['band_posisi'] = $band_posisi;
            $result['status'] = 'Lebih dari';
        }else if ($band[$result['tp_band_posisi']] != '' && $result['kategori_host']==1 && $result['tp_tgl_pens'] < '2004-08-01') {
            $select_band = 'SELECT tbp_grade from tbl_band_posisi where tbp_id="'.$result['tp_band_posisi'].'"';
            $band_posisi = Yii::$app->db->createCommand($select_band)->queryScalar();
            // echo "<pre>"; print_r($band_posisi);echo "</pre>";die();
            $data = 'SELECT `'.$band_posisi.'` FROM tbl_hak_kelas WHERE thk_rumah_sakit="'.$user->rs_mitra.'" and thk_kategori_host="PENS" and flag_active=0 and `'.$band_posisi.'` is not null';
            // echo "<pre>"; print_r($data);echo "</pre>";die();
            $result1 = Yii::$app->db->createCommand($data)->queryScalar();
            $result['hak_kelas'] = $result1;
            $result['band_posisi'] = $band_posisi;
            $result['status'] = 'Kurang Dari';
        }
        return json_encode($result);
    }

    /**
     * Creates a new Pendaftaran model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Pendaftaran();
        $model->scenario = 'create';
        if ($model->load(Yii::$app->request->post())){
                $date = date('Y-m-d', strtotime($model->td_tgl_daftar));
                if ($date <= date('Y-m-d') && $model->td_tujuan==2) {
                    $model->addError('td_tgl_daftar', 'Tgl Harus Lebih besar dari hari ini');
                    return $this->render('create', [
                        'model' => $model,
                    ]);
                }else{
                    $model->td_tgl_daftar = date('Y-m-d H:i:s');
                }
                if(isset($_FILES['Pendaftaran']['name']['td_path_rujukan'])){

                    $name = $_FILES['Pendaftaran']['name']['td_path_rujukan'];
                    $tmp_name = $_FILES['Pendaftaran']['tmp_name']['td_path_rujukan'];
                    $size = number_format($_FILES['Pendaftaran']['size']['td_path_rujukan'] / 1048576, 2);
                    $fileExplode = explode('.', $name);
                    $fileExtensions = $fileExplode[count($fileExplode)-1];
                    if (strtolower($fileExtensions) =='pdf' && $size <= 3) {
                        $model->td_path_rujukan = $this->uploadFile($tmp_name,$name,$model->td_tp_nikes);
                    }else{
                        $model->addError('td_path_rujukan', 'File Harus berformat PDF & Max. 2MB');
                        return $this->render('create', [
                            'model' => $model,
                        ]);
                    }
                }
                if(isset($_FILES['Pendaftaran']['name']['td_path_rujukan_2'])){

                    $name = $_FILES['Pendaftaran']['name']['td_path_rujukan_2'];
                    $tmp_name = $_FILES['Pendaftaran']['tmp_name']['td_path_rujukan_2'];
                    $size = number_format($_FILES['Pendaftaran']['size']['td_path_rujukan_2'] / 1048576, 2);
                    $fileExplode = explode('.', $name);
                    $fileExtensions = $fileExplode[count($fileExplode)-1];
                    if (strtolower($fileExtensions) =='pdf' && $size <= 3) {
                        $model->td_path_rujukan_2 = $this->uploadFile($tmp_name,$name,$model->td_tp_nikes.'_2');
                    }else{
                        $model->addError('td_path_rujukan_2', 'File Harus berformat PDF & Max. 2MB');
                        return $this->render('create', [
                            'model' => $model,
                        ]);
                    }
                }
                if(isset($_FILES['Pendaftaran']['name']['td_path_rujukan_3'])){

                    $name = $_FILES['Pendaftaran']['name']['td_path_rujukan_3'];
                    $tmp_name = $_FILES['Pendaftaran']['tmp_name']['td_path_rujukan_3'];
                    $size = number_format($_FILES['Pendaftaran']['size']['td_path_rujukan_3'] / 1048576, 2);
                    $fileExplode = explode('.', $name);
                    $fileExtensions = $fileExplode[count($fileExplode)-1];
                    if (strtolower($fileExtensions) =='pdf' && $size <= 3) {
                        $model->td_path_rujukan_3 = $this->uploadFile($tmp_name,$name,$model->td_tp_nikes.'_3');
                    }else{
                        $model->addError('td_path_rujukan_3', 'File Harus berformat PDF & Max. 2MB');
                        return $this->render('create', [
                            'model' => $model,
                        ]);
                    }
                }
                if ($model->validate()) {
                    $cari = Peserta::find()->select(['tp_id'])->where(['=','tp_nikes', $model->td_tp_nikes])->one();
                    $model->td_tp_id = $cari->tp_id;
                    $model->first_user =Yii::$app->user->identity->username;
                    $model->first_ip  = $_SERVER['REMOTE_ADDR'];
                    $model->first_date = date('Y-m-d H:i:s');
                    $model->td_flag_status = 1;
                    if($model->save()) {
                        $modelNotif = new Notifikasi();
                        $modelNotif->tn_kepada = 6;
                        $modelNotif->tn_tanggal = date('Y-m-d H:i:s');
                        $modelNotif->tn_judul = 'Pendaftaran';
                        $modelNotif->tn_teks = 'Pendaftaran nikes '.$model->td_tp_nikes.'.';
                        $modelNotif->tn_type_notif = 0;
                        $modelNotif->tn_telah_dikirim = 1;
                        $modelNotif->tn_telah_dibaca = 0;
                        $modelNotif->tn_jenis_kegiatan = 2;
                        $modelNotif->tn_link = str_replace('frontend', 'backend', Url::to(['pendaftaran/view', 'id' => $model->td_id]));
                        $modelNotif->tn_user_id = Yii::$app->user->id;
                        $modelNotif->save(false);
                        $attributes = $model->attributeLabels();
                        $data = "";
                        foreach ($model as $key => $value) {
                            $data .= $attributes[$key].":".$model->$key.",";
                        }
                        $activity = "[CREATE PENDAFTARAN] ".$data;
                        $this->historyUser($activity,$user,$ip);
                        Yii::$app->session->set('notif','Create Pendaftaran');
                        // return $this->redirect(['view', 'id' => $model->td_id]);
                        return $this->redirect(['index']);
                    }
                }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Pendaftaran model.
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
            if ($_FILES['Pendaftaran']['name']['td_path_rujukan']=='' && $_FILES['Pendaftaran']['name']['td_path_rujukan_2']=='' && $_FILES['Pendaftaran']['name']['td_path_rujukan_3']=='') {
                $model->td_path_rujukan=$modelOld->td_path_rujukan;
                $model->td_path_rujukan_2=$modelOld->td_path_rujukan_2;
                $model->td_path_rujukan_3=$modelOld->td_path_rujukan_3;
                $date = date('Y-m-d', strtotime($model->td_tgl_daftar));
                if ($date <= date('Y-m-d') && $model->td_tujuan==2) {
                    $model->addError('td_tgl_daftar', 'Tgl Harus Lebih besar dari hari ini');
                    return $this->render('update', [
                        'model' => $model,
                    ]);
                }else{
                    $model->td_tgl_daftar = $modelOld->td_tgl_daftar;
                }
                if ($model->validate()) {
                    $cari = Peserta::find()->select(['tp_id'])->where(['=','tp_nikes', $model->td_tp_nikes])->one();
                    $model->td_tp_id = $cari->tp_id;
                    $model->last_user =Yii::$app->user->identity->username;
                    $model->last_ip  = $_SERVER['REMOTE_ADDR'];
                    $model->last_date = date('Y-m-d H:i:s');
                    // echo "<pre>"; print_r($cari->tp_id);echo "</pre>";die();
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
                        $activity = "[UPDATE PENDAFTARAN ID : ".$id."] ".$data;
                        $this->historyUser($activity,$user,$ip);
                        Yii::$app->session->set('notif','Update Pendaftaran');
                        // return $this->redirect(['view', 'id' => $model->td_id]);
                        return $this->redirect(['index']);
                    }
                }
            }else{
                $date = date('Y-m-d', strtotime($model->td_tgl_daftar));
                if ($date <= date('Y-m-d') && $model->td_tujuan==2) {
                    $model->addError('td_tgl_daftar', 'Tgl Harus Lebih besar dari hari ini');
                    return $this->render('update', [
                        'model' => $model,
                    ]);
                }else{
                    $model->td_tgl_daftar = $modelOld->td_tgl_daftar;
                }
                if ($_FILES['Pendaftaran']['name']['td_path_rujukan']!=''){
                    $name = $_FILES['Pendaftaran']['name']['td_path_rujukan'];
                    $tmp_name = $_FILES['Pendaftaran']['tmp_name']['td_path_rujukan'];
                    $size = number_format($_FILES['Pendaftaran']['size']['td_path_rujukan'] / 1048576, 2);
                    $fileExplode = explode('.', $name);
                    $fileExtensions = $fileExplode[count($fileExplode)-1];
                    if (strtolower($fileExtensions) =='pdf' && $size <= 3) {
                        $model->td_path_rujukan = $this->uploadFile($tmp_name,$name,$model->td_tp_nikes);
                    }else{ 
                        $model->addError('td_path_rujukan', 'File Harus berformat PDF & Max. 2MB');
                        return $this->render('update', [
                            'model' => $model,
                        ]);
                    }
                }else{
                    $model->td_path_rujukan=$modelOld->td_path_rujukan;
                }
                if ($_FILES['Pendaftaran']['name']['td_path_rujukan_2']!=''){
                    $name = $_FILES['Pendaftaran']['name']['td_path_rujukan_2'];
                    $tmp_name = $_FILES['Pendaftaran']['tmp_name']['td_path_rujukan_2'];
                    $size = number_format($_FILES['Pendaftaran']['size']['td_path_rujukan_2'] / 1048576, 2);
                    $fileExplode = explode('.', $name);
                    $fileExtensions = $fileExplode[count($fileExplode)-1];
                    if (strtolower($fileExtensions) =='pdf' && $size <= 3) {
                        $model->td_path_rujukan_2 = $this->uploadFile($tmp_name,$name,$model->td_tp_nikes.'_2');
                    }else{
                        $model->addError('td_path_rujukan_2', 'File Harus berformat PDF & Max. 2MB');
                        return $this->render('update', [
                            'model' => $model,
                        ]);
                    }
                }else{
                    $model->td_path_rujukan_2=$modelOld->td_path_rujukan_2;
                }
                if ($_FILES['Pendaftaran']['name']['td_path_rujukan_3']!=''){
                    $name = $_FILES['Pendaftaran']['name']['td_path_rujukan_3'];
                    $tmp_name = $_FILES['Pendaftaran']['tmp_name']['td_path_rujukan_3'];
                    $size = number_format($_FILES['Pendaftaran']['size']['td_path_rujukan_3'] / 1048576, 2);
                    $fileExplode = explode('.', $name);
                    $fileExtensions = $fileExplode[count($fileExplode)-1];
                    if (strtolower($fileExtensions) =='pdf' && $size <= 3) {
                        $model->td_path_rujukan_3 = $this->uploadFile($tmp_name,$name,$model->td_tp_nikes.'_3');
                    }else{
                        $model->addError('td_path_rujukan_3', 'File Harus berformat PDF & Max. 2MB');
                        return $this->render('update', [
                            'model' => $model,
                        ]);
                    }
                }else{
                    $model->td_path_rujukan_3=$modelOld->td_path_rujukan_3;
                }
                    if ($model->validate()) {
                        $cari = Peserta::find()->select(['tp_id'])->where(['=','tp_nikes', $model->td_tp_nikes])->one();
                        $model->td_tp_id = $cari->tp_id;
                        $model->first_user =Yii::$app->user->identity->username;
                        $model->first_ip  = $_SERVER['REMOTE_ADDR'];
                        $model->td_tgl_daftar = date('Y-m-d H:i:s');
                        $model->first_date = date('Y-m-d H:i:s');
                        $model->td_flag_status = 1;
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
                        $activity = "[UPDATE PENDAFTARAN ID : ".$id."] ".$data;
                        $this->historyUser($activity,$user,$ip);
                        Yii::$app->session->set('notif','Update Pendaftaran');
                            // return $this->redirect(['view', 'id' => $model->td_id]);
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
     * Deletes an existing Pendaftaran model.
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
            $activity = "[DELETE PENDAFTARAN] ".$data;
            $this->historyUser($activity,$user,$ip);
            Yii::$app->session->set('notif','Delete Pendaftaran');
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the Pendaftaran model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Pendaftaran the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Pendaftaran::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
