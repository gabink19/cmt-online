<?php

namespace backend\controllers;

use Yii;
use backend\models\Persetujuan;
use backend\models\PersetujuanSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Pendaftaran;
use backend\models\Notifikasi;
use yii\helpers\Url;
use yii\data\ArrayDataProvider;

/**
 * HistoryPersetujuanController implements the CRUD actions for Persetujuan model.
 */
class HistoryPersetujuanController extends MainController 
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
        $dataProvider = $searchModel->historysearch($params);

        if(isset($_GET['PersetujuanSearch'])){
            $searchModel->start_periode = $_GET['PersetujuanSearch']['start_periode'];
            $searchModel->stop_periode = $_GET['PersetujuanSearch']['stop_periode'];
            $searchModel->tujuan = $_GET['PersetujuanSearch']['tujuan'];
        }
        $newdataProvider  = [];
        $newdataProvider2 = [];
        foreach ($dataProvider->query->all() as $key => $value) {
        	$newdataProvider[$value->tpt_uniq_code] = $value;
        }
        $no = 0 ;
        foreach ($newdataProvider as $key => $value) {
        	$newdataProvider2[$value->tpt_id] = $value;
        	$no++;
        }
        $provider = new ArrayDataProvider([
		    'allModels' => $newdataProvider2,
		    // 'sort' => $sort, // HERE is your $sort
		    'pagination' => [
		        'pageSize' => 10,
		    ],
		]);
//         echo "<pre>"; print_r($provider);echo "</pre>";
// die();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $provider,
        ]);
    }

    /**
     * Displays a single Persetujuan model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id,$uniq_code)
    {
    	// echo "<pre>"; print_r(this);echo "</pre>";die();

        $q = 'select tpt_catatan_mitra,tpt_catatan_yakes,tgl_permintaan,tgl_persetujuan from tbl_persetujuan_tindak where tpt_uniq_code="'.$uniq_code.'"';
        $d = Yii::$app->db->createCommand($q)->queryAll();
        $model = $this->findModel($id);

        $history_catatan = '';
        foreach ($d as $key => $value) {
            $history_catatan .= $value['tgl_permintaan'];
            $history_catatan .= " Catatan Mitra : ".$value['tpt_catatan_mitra']."<br><br>";
            $history_catatan .= $value['tgl_persetujuan'];
            $history_catatan .= " Catatan Yakes : ".$value['tpt_catatan_yakes']."<br><br>";
        }

        $model->history_catatan = $history_catatan;
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function uploadFile($tempName,$fileName,$nikes='') 
    {
        $explodeFile = explode('.',$fileName);
        $fileName = $nikes.'_'.date("Y-m-d_H:i:s").'.'.$explodeFile[1];
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
                        $model->tpt_id_user_backend  = @$user->id;
                        $model->tpt_nama_mitra  = Yii::$app->user->identity->rs_mitra;
                        $model->first_user_backend = @$user->username;
                        $model->first_ip_backend  = $_SERVER['REMOTE_ADDR'];
                        $model->first_date_backend = date('Y-m-d H:i:s');
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
                            $modelNotif->tn_link = str_replace('backend', 'backend', Url::to(['persetujuan/update', 'id' => $model->tpt_id]));
                            $modelNotif->tn_user_id = Yii::$app->user->id;
                            $modelNotif->save(false);
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
                    $model->last_user_backend =@$user->username;
                    $model->last_ip_backend  = $_SERVER['REMOTE_ADDR'];
                    $model->last_date_backend = date('Y-m-d H:i:s');
                    if($model->save()) {
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
                        $model->last_user_backend =@$user->username;
                        $model->last_ip_backend  = $_SERVER['REMOTE_ADDR'];
                        $model->last_date_backend = date('Y-m-d H:i:s');
                        if($model->save()) {
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
