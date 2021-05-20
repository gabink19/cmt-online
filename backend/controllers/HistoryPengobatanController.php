<?php

namespace backend\controllers;

use Yii;
use frontend\models\BillingFinal;
use frontend\models\BillingFinalSearch;
use frontend\models\Pendaftaran ;
use frontend\models\PendaftaranSearch;
use frontend\models\Notifikasi;
use frontend\models\PesertaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Url;

/**
 * BillingFinalController implements the CRUD actions for BillingFinal model.
 */
class HistoryPengobatanController extends MainController 
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

    public function uploadFile($tempName,$fileName,$nikes='') 
    {
        $explodeFile = explode('.',$fileName);
        $fileName = $nikes.'_'.date("Y-m-d_H:i:s").'.'.$explodeFile[1];
        // shell_exec('chmod 777 -R '.Yii::$app->params['pathPermintaan']);
        // chmod(Yii::$app->params['pathPermintaan'], 0777);
        // echo "<pre>"; print_r(getcwd());echo "</pre>";die();
        if (!move_uploaded_file($tempName, Yii::$app->params['pathBilling'] .date('Y').'/'.date('m').'/'. $fileName)) {
            return '';
        }
        return Yii::$app->params['pathBilling'] .date('Y').'/'.date('m').'/'.$fileName;
    }
    public function actionBilling($value='')
    {
        $params = Yii::$app->request->queryParams;
        // $params['PendaftaranSearch']['td_flag_status'] = 1;
        // echo "<pre>"; print_r($params);echo "</pre>";
        $searchModel = new PendaftaranSearch();
        $dataProvider = $searchModel->searchPersetujuan($params);

        $searchModel->start_periode = isset($_GET['PendaftaranSearch'])?$_GET['PendaftaranSearch']['start_periode']:null;
        $searchModel->stop_periode = isset($_GET['PendaftaranSearch'])?$_GET['PendaftaranSearch']['stop_periode']:null;

        return $this->render('billingFinal', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionDownloadpdf($nikes)
    {   
        $filename = Yii::$app->params['temp_pdf'].$nikes.'_historypengobatan.pdf';
        $file_exist = file_exists($filename);
        if ($file_exist) {
            unlink($filename);
        }
        shell_exec("/usr/local/bin/wkhtmltopdf --page-size 'A4' --orientation 'landscape' --page-width '1024' --enable-javascript --encoding 'UTF-8'  'https://www.cmt-online.site/index.php?r=history-pengobatan%2Fpdf&nikes=".$nikes."' '".$filename."'");

        return $this->redirect(['/persetujuan/download', 'filename' => $filename]);
    }
    public function actionPdf($nikes)
    {
        $this->layout = false;
        $params = Yii::$app->request->queryParams;

        $searchModel = new BillingFinalSearch();
        $dataProvider = $searchModel->historysearchChild($params,$nikes);

        $quer = 'SELECT * FROM tbl_peserta WHERE tp_nikes="'.$nikes.'"';
        $peserta = Yii::$app->db->createCommand($quer)->queryOne();

        return $this->render('pdf',['model' => $dataProvider->getModels(),'peserta'=>$peserta]);
    }
    /**
     * Lists all BillingFinal models.
     * @return mixed
     */
    public function actionIndex()
    {
        $params = Yii::$app->request->queryParams;

        $searchModel = new PesertaSearch();
        $dataProvider = $searchModel->historysearch($params);
        // echo "<pre>"; print_r($dataProvider->query->all());echo "</pre>";die();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BillingFinal model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $url = '/frontend'.Url::to(['billing-sementara/view', 'id' => $id]);
        $query = 'UPDATE tbl_notifikasi SET tn_telah_dibaca="1",tn_dibaca_tanggal="'.date('Y-m-d H:i:s').'" WHERE tn_type_notif="1" AND tn_telah_dikirim="1" AND tn_telah_dibaca="0" AND flag_deleted="0" AND tn_link="'.$url.'"' ;
        $result = Yii::$app->db->createCommand($query)->execute();
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    public function actionView2($id)
    {
        $model = Pendaftaran::findOne($id);
        return $this->render('view2', [
            'model' => $model,
        ]);
    }
    public function actionDaftar($nikes,$newrecord)
    {
        $data = 'SELECT * FROM tbl_daftar WHERE td_tp_nikes="'.$nikes.'" and flag_deleted=0 order by td_id LIMIT 1';
        $result = Yii::$app->db->createCommand($data)->queryOne();
        if (!$result && $nikes!='') {
            return json_encode(100);
        }else{
            $data = 'SELECT count(*) FROM tbl_billing_final WHERE tbs_tp_nikes="'.$nikes.'" and flag_deleted=0 order by tbs_id LIMIT 1';
            $avail = Yii::$app->db->createCommand($data)->queryScalar();
            if ($avail>0 && $newrecord=='true') {
                return json_encode(101);
            }else{
                return json_encode($result);
            }
        }
    }
    /**
     * Creates a new BillingFinal model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BillingFinal();
        $model->scenario = 'create';

        if ($model->load(Yii::$app->request->post())){
            $name = $_FILES['BillingFinal']['name']['tbs_path_billing'];
            $tmp_name = $_FILES['BillingFinal']['tmp_name']['tbs_path_billing'];
            $size = number_format($_FILES['BillingFinal']['size']['tbs_path_billing'] / 1048576, 2);
            $fileExplode = explode('.', $name);
            $fileExtensions = $fileExplode[count($fileExplode)-1];

            $data = 'SELECT count(*) FROM tbl_daftar WHERE td_tp_nikes="'.$model->tbs_tp_nikes.'" order by td_id LIMIT 1';
            $result = Yii::$app->db->createCommand($data)->queryScalar();
            if ($result>0) {
                if (strtolower($fileExtensions) =='pdf' && $size <= 3) {
                    $model->tbs_path_billing = $this->uploadFile($tmp_name,$name,$model->tbs_tp_nikes);
                    $model->tbs_id_user_frontend = Yii::$app->user->identity->id;
                    $model->tgl_billing = date('Y-m-d H:i:s');
                    $model->first_ip_frontend = $_SERVER['REMOTE_ADDR'];
                    $model->first_date_frontend = date('Y-m-d H:i:s');
                    $model->first_user_frontend = Yii::$app->user->identity->username;
                    $model->flag_deleted = 0;
                    if ($model->save()) {
                            $query = 'UPDATE tbl_daftar SET td_flag_status="5" WHERE td_id = "'.$model->tbs_td_id.'" AND td_tp_nikes="'.$model->tbs_tp_nikes.'" AND flag_deleted="0"' ;
                            $result = Yii::$app->db->createCommand($query)->execute();
                            // $modelNotif = new Notifikasi();
                            // $modelNotif->tn_kepada = 6;
                            // $modelNotif->tn_tanggal = date('Y-m-d H:i:s');
                            // $modelNotif->tn_judul = 'Billing Final';
                            // $modelNotif->tn_teks = 'Billing Final pada nikes '.$model->tbs_tp_nikes.'.';
                            // $modelNotif->tn_type_notif = 0;
                            // $modelNotif->tn_telah_dikirim = 1;
                            // $modelNotif->tn_telah_dibaca = 0;
                            // $modelNotif->tn_jenis_kegiatan = 2;
                            // $modelNotif->tn_link = str_replace('frontend', 'backend', Url::to(['billing-sementara/update', 'id' => $model->tbs_id]));
                            // $modelNotif->tn_user_id = Yii::$app->user->id;
                            // $modelNotif->save(false);

                        Yii::$app->session->set('notif','Create Billing');
                        // return $this->redirect(['view', 'id' => $model->tbs_id]);
                        return $this->redirect(['index']);
                    }else{
                        // echo "<pre>"; print_r($model->getErrors());echo "</pre>";
                    }
                }
            }else{
                $model->addError('tbs_tp_nikes', 'Nikes Belum Melakukan Pendaftaran');
            }
        } 

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new BillingFinal model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionInstantCreate()
    {
        $model = new BillingFinal();
        // $model->scenario = 'create';

        if ($model->load(Yii::$app->request->post())){
            $name = $_FILES['BillingFinal']['name']['tbs_path_billing'];
            $tmp_name = $_FILES['BillingFinal']['tmp_name']['tbs_path_billing'];
            $size = number_format($_FILES['BillingFinal']['size']['tbs_path_billing'] / 1048576, 2);
            $fileExplode = explode('.', $name);
            $fileExtensions = $fileExplode[count($fileExplode)-1];

            $data = 'SELECT count(*) FROM tbl_daftar WHERE td_tp_nikes="'.$model->tbs_tp_nikes.'" order by td_id LIMIT 1';
            $result = Yii::$app->db->createCommand($data)->queryScalar();
            if ($result>0) {
                if (strtolower($fileExtensions) =='pdf' && $size <= 3) {
                    $model->tbs_path_billing = $this->uploadFile($tmp_name,$name,$model->tbs_tp_nikes);
                    $model->tbs_id_user_frontend = Yii::$app->user->identity->id;
                    $model->tgl_billing = date('Y-m-d H:i:s');
                    $model->first_ip_frontend = $_SERVER['REMOTE_ADDR'];
                    $model->first_date_frontend = date('Y-m-d H:i:s');
                    $model->first_user_frontend = Yii::$app->user->identity->username;
                    $model->flag_deleted = 0;
                    if ($model->save()) {
                            $query = 'UPDATE tbl_daftar SET td_flag_status="5" WHERE td_id = "'.$model->tbs_td_id.'" AND td_tp_nikes="'.$model->tbs_tp_nikes.'" AND flag_deleted="0"' ;
                            // echo "<pre>aa "; print_r($query);echo "</pre>";die();
                            $result = Yii::$app->db->createCommand($query)->execute();
                            $modelNotif = new Notifikasi();
                            $modelNotif->tn_kepada = 6;
                            $modelNotif->tn_tanggal = date('Y-m-d H:i:s');
                            $modelNotif->tn_judul = 'Billing Final';
                            $modelNotif->tn_teks = 'Billing Final pada nikes '.$model->tbs_tp_nikes.'.';
                            $modelNotif->tn_type_notif = 0;
                            $modelNotif->tn_telah_dikirim = 1;
                            $modelNotif->tn_telah_dibaca = 0;
                            $modelNotif->tn_jenis_kegiatan = 2;
                            $modelNotif->tn_link = str_replace('frontend', 'backend', Url::to(['billing-final/update', 'id' => $model->tbs_id]));
                            $modelNotif->tn_user_id = Yii::$app->user->id;
                            $modelNotif->save(false);

                        Yii::$app->session->set('notif','Create Billing');
                        // return $this->redirect(['view', 'id' => $model->tbs_id]);
                        return $this->redirect(['index']);
                    }else{
                        // echo "<pre>"; print_r($model->getErrors());echo "</pre>";
                    }
                }else{
                    $model->addError('tpt_path_permintaan_tindak', 'File Harus berformat PDF & Max. 2MB');
                }
            // echo "<pre>"; print_r($_FILES);echo "</pre>";
            }else{
                $model->addError('tbs_tp_nikes', 'Nikes Belum Melakukan Pendaftaran');
            }
        } 
        $model->tbs_tp_nikes = $_GET['nikes'];
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing BillingFinal model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->tbs_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing BillingFinal model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        Yii::$app->session->set('notif','Delete Billing');

        return $this->redirect(['index']);
    }

    /**
     * Finds the BillingFinal model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BillingFinal the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BillingFinal::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
