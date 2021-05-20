<?php

namespace backend\controllers;

use Yii;
use backend\models\ReportTrackingHistory;
use backend\models\ReportTrackingHistorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ReportTrackingHistoryController implements the CRUD actions for ReportTrackingHistory model.
 */
class ReportTrackingHistoryController extends MainController 
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
     * Lists all ReportTrackingHistory models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ReportTrackingHistorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if(isset($params['ReportTrackingHistorySearch'])){
            $searchModel->start_periode = $params['ReportTrackingHistorySearch']['start_periode'];
            $searchModel->tujuan = $params['ReportTrackingHistorySearch']['tujuan'];
            $searchModel->mitra = $params['ReportTrackingHistorySearch']['mitra'];
            $searchModel->host = $params['ReportTrackingHistorySearch']['host'];
            $searchModel->stop_periode = $params['ReportTrackingHistorySearch']['stop_periode'];
        }

        Yii::$app->session->set('session_tracking',$params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCsv()
    {
       ini_set('memory_limit', '4095M');
       ini_set('max_execution_time', 0);
       $start = microtime(true);
       $searchModel = new ReportTrackingHistorySearch();
       $dataProvider = $searchModel->search(Yii::$app->session->get('session_tracking'));
       $dataProvider->pagination  = false;

       // echo "<pre>"; print_r(Yii::$app->session->get('session_peserta'));echo "</pre>";

       $header = "Reporting Approval\n\n Nikes\tPasien\tUmur\tKategori Host\tTujuan\tMitra\tTanggal Masuk\tTanggal Keluar\tBiaya \n";
       header("Content-type: application/text-plain");
       header("Content-Disposition: attachment; filename=Report_Approval_".date('Ymd').".xls");
       header("Pragma: no-cache");
       header("Expires: 0");
           
       echo $header;

       foreach ($dataProvider->getModels() as $key => $value) {
        $data = $value->attributes;

        echo "\"".$data['tbs_tp_nikes']."\"\t\"".$this->getDaftar($data['tbs_td_id'])."\"\t\"".$this->getDaftar($data['tbs_td_id'],2)."\"\t\"".$this->getDaftar($data['tpt_td_id'],3)."\"\t\"".$this->getDaftar($data['tpt_td_id'],4)."\"\t\"".$this->getDaftar($data['tpt_td_id'],1)."\"\t\"".$data['tgl_billing']."\"\t\"".$data['tgl_billing_diresponse']."\"\t\"".$data['tbs_biaya']."\" \n";
       }

        $time = microtime(true) - $start;
        // echo $time;
       exit;
    }

    /**
     * Displays a single ReportTrackingHistory model.
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

    /**
     * Creates a new ReportTrackingHistory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ReportTrackingHistory();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->tbs_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ReportTrackingHistory model.
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

    public function getDaftar($id, $flag=0){
        $sql = "SELECT td_tp_nama_kk from tbl_daftar where td_id='".$id."'";
        if($flag == 1){
            $sql = "SELECT td_mitra from tbl_daftar where td_id='".$id."'";
        }
        if($flag == 2){
            $sql = "SELECT td_umur from tbl_daftar where td_id='".$id."'";
        }
        if($flag == 3){
            // $sql = "SELECT td_flag_status from tbl_daftar where td_id='".$id."'";
            $sql = "SELECT td_tp_id from tbl_daftar where td_id='".$id."'";
        }
        if($flag == 4){
            $sql = "SELECT td_tujuan from tbl_daftar where td_id='".$id."'";
        }

        $db = Yii::$app->db->createCommand($sql)->queryScalar();

        if($flag == 3){
            // $sql = "SELECT td_flag_status from tbl_daftar where td_id='".$id."'";
            $sql = "SELECT kategori_host from tbl_peserta where tp_id='".$db."'";
            $db = Yii::$app->db->createCommand($sql)->queryScalar();
        }

        return $db;
    }

    /**
     * Deletes an existing ReportTrackingHistory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ReportTrackingHistory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ReportTrackingHistory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ReportTrackingHistory::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
