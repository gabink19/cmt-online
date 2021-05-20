<?php

namespace backend\controllers;

use Yii;
use app\models\ReportLos;
use backend\models\ReportLosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ReportLosController implements the CRUD actions for ReportLos model.
 */
class ReportLosController extends MainController 
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
     * Lists all ReportLos models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ReportLosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ReportLos model.
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
     * Creates a new ReportLos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ReportLos();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->tbs_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function getRentang($date, $date2){
        if($date != "" && $date2 != ""){
            $datetime1 = date_create($date);
            $datetime2 = date_create($date2);

            $interval = date_diff($datetime1, $datetime2);

            $days = $interval->d;
            $minute = $interval->i;
            $second = $interval->s;

            $hasil = $days." hari ".$minute." menit ".$second." detik.";
            if($days == 0){
                $hasil = $minute." menit ".$second." detik.";
                if($minute == 0){
                    $hasil = $second." detik.";
                }
            }
            return $hasil;
        }
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
        if($flag == 5){
            $sql = "SELECT td_flag_status from tbl_daftar where td_id='".$id."'";
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
     * Updates an existing ReportLos model.
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
     * Deletes an existing ReportLos model.
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
     * Finds the ReportLos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ReportLos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ReportLos::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
