<?php

namespace backend\controllers;

use Yii;
use backend\models\Pendaftaran;
use backend\models\PendaftaranSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Peserta;
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
        $url = 'pendaftaran%2Fview&id='.$id;
        $query = 'UPDATE tbl_notifikasi SET tn_telah_dibaca="1",tn_dibaca_tanggal="'.date('Y-m-d H:i:s').'" WHERE tn_type_notif="0" AND tn_telah_dikirim="1" AND tn_telah_dibaca="0" AND flag_deleted="0" AND tn_link LIKE "%'.$url.'%"' ;
        $result = Yii::$app->db->createCommand($query)->execute();
        // echo "<pre>"; print_r($query);echo "</pre>";
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function uploadFile($tempName,$fileName) 
    {
        $explodeFile = explode('.',$fileName);
        $fileName = $explodeFile[0].'_'.date("Y-m-d_H:i:s").'.'.end($explodeFile);
        // shell_exec('chmod 777 -R '.Yii::$app->params['pathPermintaan']);
        // chmod(Yii::$app->params['pathPermintaan'], 0777);
        // echo "<pre>"; print_r(getcwd());echo "</pre>";die();
        if (!move_uploaded_file($tempName, Yii::$app->params['pathPermintaan'] . $fileName)) {
            return '';
        }
        return Yii::$app->params['pathPendaftaran'] .$fileName;
    }

    public function actionPeserta($td_tp_nikes)
    {
        $data = 'SELECT * FROM tbl_peserta WHERE tp_nikes="'.$td_tp_nikes.'"';
        $result = Yii::$app->db->createCommand($data)->queryOne();
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
            $name = $_FILES['Pendaftaran']['name']['td_path_rujukan'];
            $tmp_name = $_FILES['Pendaftaran']['tmp_name']['td_path_rujukan'];
            $size = number_format($_FILES['Pendaftaran']['size']['td_path_rujukan'] / 1048576, 2);
            $fileExplode = explode('.', $name);
            $fileExtensions = $fileExplode[count($fileExplode)-1];
            if (strtolower($fileExtensions) =='pdf' && $size <= 3) {
                $model->td_path_rujukan = $this->uploadFile($tmp_name,$name);
                if ($model->validate()) {
                    $cari = Peserta::find()->select(['tp_id'])->where(['=','tp_nikes', $model->td_tp_nikes])->one();
                    $model->td_tp_id = $cari->tp_id;
                    $model->first_user =$this->userSelf();
                    $model->first_ip  = $_SERVER['REMOTE_ADDR'];
                    $model->td_tgl_daftar = date('Y-m-d H:i:s');
                    $model->first_date = date('Y-m-d H:i:s');
                    $model->td_flag_status = 1;
                    if($model->save()) {
                        $attributes = $model->attributeLabels();
                        $data = "";
                        foreach ($model as $key => $value) {
                            $data .= $attributes[$key].":".$model->$key.",";
                        }
                        $activity = "[CREATE PENDAFTARAN] ".$data;
                        $this->historyUser($activity,$user,$ip);

                        Yii::$app->session->set('notif','Create Pendaftaran');
                        // return $this->redirect(['view', 'id' => $model->td_id]);
                        if (isset($_GET['FlagMobile']) && $_GET['FlagMobile']=='true' && isset($_GET['IdUser']) && $_GET['IdUser']!='') {
                            return $this->redirect(['index','FlagMobile'=>'true','IdUser'=>$_GET['IdUser']]);
                        }else{
                            return $this->redirect(['index']);
                        }
                    }
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
        $session = Yii::$app->session;
        $band = @ArrayHelper::map($session->get('band'), 'tbp_id', 'tbp_penamaan');

        if ($model->load(Yii::$app->request->post())){
            if ($_FILES['Pendaftaran']['name']['td_path_rujukan']=='') {
                $model->td_path_rujukan=$modelOld->td_path_rujukan;
                if ($model->validate()) {
                    $cari = Peserta::find()->where(['=','tp_nikes', $model->td_tp_nikes])->one();
                    $model->td_tp_id = $cari->tp_id;
                    $model->last_user =$this->userSelf();
                    $model->last_ip  = $_SERVER['REMOTE_ADDR'];
                    $model->last_date = date('Y-m-d H:i:s');
                     if ($cari->tp_tgl_pens > '2004-08-01') {
                        if (strpos($band[$cari->tp_band_posisi], '.') !== false) {
                            $band_posisi = explode('.', $band[$cari->tp_band_posisi])[0];
                        }else{
                            $band_posisi = $band[$cari->tp_band_posisi];
                        }
                        $updateConfigHak = "UPDATE tbl_hak_kelas SET `".$band_posisi."`= '".$model->td_hak_kelas."' WHERE thk_rumah_sakit='".$model->td_mitra."'  and thk_kategori_host='PEGAWAI'";
                    }else{
                        $select_band = 'SELECT tbp_grade from tbl_band_posisi where tbp_id="'.$cari->tp_band_posisi.'"';
                        $band_posisi = Yii::$app->db->createCommand($select_band)->queryScalar();
                        $updateConfigHak = "UPDATE tbl_hak_kelas SET `".$band_posisi."`= '".$model->td_hak_kelas."' WHERE thk_rumah_sakit='".$model->td_mitra."' and thk_kategori_host='PENS' ";
                    }
                    // echo "<pre>"; print_r($band);echo "</pre>";die();
                    if($model->save()) {
                        $exec = Yii::$app->db->createCommand($updateConfigHak)->execute();
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
                        
                        if (isset($_GET['FlagMobile']) && $_GET['FlagMobile']=='true' && isset($_GET['IdUser']) && $_GET['IdUser']!='') {
                            return $this->redirect(['index','FlagMobile'=>'true','IdUser'=>$_GET['IdUser']]);
                        }else{
                            return $this->redirect(['index']);
                        }
                    }
                }
            }else{
                $name = $_FILES['Pendaftaran']['name']['td_path_rujukan'];
                $tmp_name = $_FILES['Pendaftaran']['tmp_name']['td_path_rujukan'];
                $size = number_format($_FILES['Pendaftaran']['size']['td_path_rujukan'] / 1048576, 2);
                $fileExplode = explode('.', $name);
                $fileExtensions = $fileExplode[count($fileExplode)-1];
                if (strtolower($fileExtensions) =='pdf' && $size <= 3) {
                    $model->td_path_rujukan = $this->uploadFile($tmp_name,$name);
                    if ($model->validate()) {
                        $cari = Peserta::find()->where(['=','tp_nikes', $model->td_tp_nikes])->one();
                        $model->td_tp_id = $cari->tp_id;
                        $model->first_user =$this->userSelf();
                        $model->first_ip  = $_SERVER['REMOTE_ADDR'];
                        $model->td_tgl_daftar = date('Y-m-d H:i:s');
                        $model->first_date = date('Y-m-d H:i:s');
                        $model->td_flag_status = 1;
                    if ($cari->tp_tgl_pens > '2004-08-01') {
                        if (strpos($band[$cari->tp_band_posisi], '.') !== false) {
                            $band_posisi = explode('.', $band[$cari->tp_band_posisi])[0];
                        }else{
                            $band_posisi = $band[$cari->tp_band_posisi];
                        }
                        $updateConfigHak = "UPDATE tbl_hak_kelas SET `".$band_posisi."`= '".$model->td_hak_kelas."' WHERE thk_rumah_sakit='".$model->td_mitra."' ";
                    }else{
                        $select_band = 'SELECT tbp_grade from tbl_band_posisi where tbp_id="'.$cari->tp_band_posisi.'"';
                        $band_posisi = Yii::$app->db->createCommand($select_band)->queryScalar();
                        $updateConfigHak = "UPDATE tbl_hak_kelas SET `".$band_posisi."`= '".$model->td_hak_kelas."' WHERE thk_rumah_sakit='".$model->td_mitra."' ";
                    }
                        if($model->save()) {
                            $exec = Yii::$app->db->createCommand($updateConfigHak)->execute();
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
                            
                            if (isset($_GET['FlagMobile']) && $_GET['FlagMobile']=='true' && isset($_GET['IdUser']) && $_GET['IdUser']!='') {
                                return $this->redirect(['index','FlagMobile'=>'true','IdUser'=>$_GET['IdUser']]);
                            }else{
                                return $this->redirect(['index']);
                            }
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
            
            if (isset($_GET['FlagMobile']) && $_GET['FlagMobile']=='true' && isset($_GET['IdUser']) && $_GET['IdUser']!='') {
                return $this->redirect(['index','FlagMobile'=>'true','IdUser'=>$_GET['IdUser']]);
            }else{
                return $this->redirect(['index']);
            }
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
