<?php

namespace backend\controllers;

use Yii;
use backend\models\PersetujuanTindak;
use backend\models\PersetujuanTindakSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\Diagnosa;
use yii\helpers\ArrayHelper;

/**
 * ReportApprovalController implements the CRUD actions for PersetujuanTindak model.
 */
class ReportApprovalController extends MainController 
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
     * Lists all PersetujuanTindak models.
     * @return mixed
     */
    public function actionIndex()
    {
        $params = Yii::$app->request->queryParams;
        $searchModel = new PersetujuanTindakSearch();
        $dataProvider = $searchModel->search($params);
        if(isset($params['PersetujuanTindakSearch'])){
            $searchModel->approve = $params['PersetujuanTindakSearch']['approve'];
            $searchModel->tujuan = $params['PersetujuanTindakSearch']['tujuan'];
            $searchModel->tpt_nama_mitra = $params['PersetujuanTindakSearch']['tpt_nama_mitra'];
            $searchModel->tpt_tp_nikes = $params['PersetujuanTindakSearch']['tpt_tp_nikes'];
        }

        Yii::$app->session->set('session_approval',$params);

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
       $searchModel = new PersetujuanTindakSearch();
       $dataProvider = $searchModel->search(Yii::$app->session->get('session_approval'));
       $dataProvider->pagination  = false;

       // echo "<pre>"; print_r(Yii::$app->session->get('session_peserta'));echo "</pre>";

       $header = "Reporting Approval\n\n Nikes\tPasien\tDiagnosa\tMitra\tTujuan\tTanggal Masuk\tTanggal Approve\tApproved By\tStatus\tLama Proses Approve \n";
       header("Content-type: application/text-plain");
       header("Content-Disposition: attachment; filename=Report_Approval_".date('Ymd').".xls");
       header("Pragma: no-cache");
       header("Expires: 0");
           
       echo $header;

       foreach ($dataProvider->getModels() as $key => $value) {
        $data = $value->attributes;

        echo "\"".$data['tpt_tp_nikes']."\"\t\"".$this->getDaftar($data['tpt_td_id'])."\"\t\"".ArrayHelper::map(Diagnosa::find()->where(['tdg_id' => $data['tpt_diagnosa']])->all(),'tdg_id','tdg_penamaan')[$data['tpt_diagnosa']]."\"\t\"".$this->getDaftar($data['tpt_td_id'],1)."\"\t\"".$this->getDaftar($data['tpt_td_id'],2)."\"\t\"".$data['tgl_permintaan']."\"\t\"".$data['tgl_persetujuan']."\"\t\"".$data['last_user_backend']."\"\t\"".Yii::$app->params['status_daftar'][$this->getDaftar($data['tpt_td_id'],3)]."\"\t\"".$this->getRentang($data['first_date_frontend'],$data['last_date_backend'])."\" \n";
       }

        $time = microtime(true) - $start;
        // echo $time;
       exit;
    }

    /**
     * Displays a single PersetujuanTindak model.
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
     * Creates a new PersetujuanTindak model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PersetujuanTindak();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->tpt_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing PersetujuanTindak model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->tpt_id]);
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
        	$sql = "SELECT td_tujuan from tbl_daftar where td_id='".$id."'";
        }
        if($flag == 3){
            $sql = "SELECT td_flag_status from tbl_daftar where td_id='".$id."'";
        }

        $db = Yii::$app->db->createCommand($sql)->queryScalar();

        return $db;
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

    /**
     * Deletes an existing PersetujuanTindak model.
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
     * Finds the PersetujuanTindak model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PersetujuanTindak the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PersetujuanTindak::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
