<?php

namespace backend\controllers;

use Yii;
use backend\models\Dashboard;
use backend\models\DashboardSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DashboardController implements the CRUD actions for Dashboard model.
 */
class DashboardController extends MainController 
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
     * Lists all Dashboard models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DashboardSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $searchModel->start = date('Y-m-d', strtotime('-1 month'));
        $searchModel->stop = date('Y-m-d');

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionDiagram(){
    	$start = date('Y-m-d H:00:00', strtotime($_GET['start']));
    	$stop = date('Y-m-d H:59:59', strtotime($_GET['stop']));

    	$type = 5; 
    	$time  = $this->getListTanggal($start,$stop,$type);
    	foreach($time as $idHad5=>$valHad5){
            if ($type == 5) {
                $tgl1 = explode(' ', $valHad5);
                $tanggal = explode('-', $tgl1[0]);
                $datefrom2 = date("M-Y", mktime(0, 0, 0, $tanggal[1], $tanggal[2], $tanggal[0]));
                $valHad5 = $datefrom2;
            }
            $timec[] = $valHad5;
        }
        
        $sql = "SELECT ttd_penamaan, ttd_tdg_kode from tbl_top_diagnosa WHERE flag_deleted=0";
        $db = Yii::$app->db->createCommand($sql)->queryAll();

        foreach ($db as $key => $value) {
        	$top_name = $value['ttd_penamaan'];
        	$diagnosa_code = explode(",", $value['ttd_tdg_kode']);
        	foreach ($timec as $key => $value) {
            	$data[$top_name][$value] = 0;
        	}
        }

        foreach ($db as $key => $value) {
        	$top_name = $value['ttd_penamaan'];
        	$diagnosa_code = explode(",", $value['ttd_tdg_kode']);
        	$sqlPt = "SELECT DATE_FORMAT(first_date_frontend,'%Y-%m-%d') as tanggal, b.tdg_kode from tbl_persetujuan_tindak  a INNER JOIN tbl_diagnosa b on a.tpt_diagnosa = b.tdg_id where a.flag_deleted=0 AND first_date_frontend BETWEEN '".$start."' and '".$stop."'";
        	
        	$dbPt = Yii::$app->db->createCommand($sqlPt)->queryAll();
        	
        	foreach ($dbPt as $keyPt => $valuePt) {
        		foreach ($diagnosa_code as $key_code => $val_code) {
        			if($valuePt['tdg_kode'] == $val_code){
                        if ($type == 5) {
                            $tgl1 = explode(' ', $valuePt['tanggal']);
                            $tanggal = explode('-', $tgl1[0]);
                            $datefrom3 = date("M-Y", mktime(0, 0, 0, $tanggal[1], $tanggal[2], $tanggal[0]));
                            $valHad6 = $datefrom3;
                        }
        				if($data[$top_name][$valHad6] == 0){
        					$sum = 1;
        				}else{
        					$sum++;
        				}
        				
        				$data[$top_name][$valHad6] = $sum;
        			}
        		}
        	}
        }

        foreach ($data as $keyF => $valueF) {
        	foreach ($valueF as $keyFF => $valueFF) {
        		$dapathp[] = $valueFF;   
        	}
        	$dataH[]=["name"=>$keyF, "data"=>$dapathp];
        	unset($dapathp);
        }
        $judulping = array('text' => 'Total Campaign');
        
        echo json_encode(["data"=> $dataH , "xaxis"=>$timec , "title"=>"Top Six Diagnosa","yaxis"=>$judulping]);
        die();
        // echo $hasil;
    }
    public function actionDiagram2(){
        $start = date('Y-m-d H:00:00', strtotime($_GET['start']));
        $stop = date('Y-m-d H:59:59', strtotime($_GET['stop']));

        $type = 5; 
        $time  = $this->getListTanggal($start,$stop,$type);
        foreach($time as $idHad5=>$valHad5){
            if ($type == 5) {
                $tgl1 = explode(' ', $valHad5);
                $tanggal = explode('-', $tgl1[0]);
                $datefrom2 = date("M-Y", mktime(0, 0, 0, $tanggal[1], $tanggal[2], $tanggal[0]));
                $valHad5 = $datefrom2;
            }
            $timec[] = $valHad5;
        }
        
        $db = Yii::$app->params['dashboard_status'];

        foreach ($db as $keysa => $valuesa) {
            $status = $valuesa;
            foreach ($timec as $key => $value) {
                $data[$status][$value] = 0;
            }
        }

        foreach ($db as $key => $value) {
            $status = $value;
            $diagnosa_code = explode(",", $value['ttd_tdg_kode']);
            $sqlPt = "SELECT DATE_FORMAT(first_date_frontend,'%Y-%m-%d') as tanggal, tbs_flag_status from tbl_billing_final where flag_deleted=0 AND tbs_flag_status='".$key."' AND first_date_frontend BETWEEN '".$start."' and '".$stop."'";
            
            $dbPt = Yii::$app->db->createCommand($sqlPt)->queryAll();
            
            foreach ($dbPt as $keyPt => $valuePt) {
                    if($key == $valuePt['tbs_flag_status']){
                        if ($type == 5) {
                            $tgl1 = explode(' ', $valuePt['tanggal']);
                            $tanggal = explode('-', $tgl1[0]);
                            $datefrom3 = date("M-Y", mktime(0, 0, 0, $tanggal[1], $tanggal[2], $tanggal[0]));
                            $valHad6 = $datefrom3;
                        }
                        if($data[$status][$valHad6] == 0){
                            $sum = 1;
                        }else{
                            $sum++;
                        }
                        $data[$status][$valHad6] = $sum;
                    }
            }
        }

        foreach ($data as $keyF => $valueF) {
            foreach ($valueF as $keyFF => $valueFF) {
                $dapathp[] = $valueFF;   
            }
            $dataH[]=["name"=>$keyF, "data"=>$dapathp];
            unset($dapathp);
        }
        $judulping = array('text' => 'Total Campaign');
        
        echo json_encode(["data"=> $dataH , "xaxis"=>$timec , "title"=>"Billing Final Status","yaxis"=>$judulping]);
        die();
        // echo $hasil;
    }
    public function actionDiagram3(){
        $start = date('Y-m-d H:00:00', strtotime($_GET['start']));
        $stop = date('Y-m-d H:59:59', strtotime($_GET['stop']));

        $type = 5; 
        $time  = $this->getListTanggal($start,$stop,$type);
        foreach($time as $idHad5=>$valHad5){
            if ($type == 5) {
                $tgl1 = explode(' ', $valHad5);
                $tanggal = explode('-', $tgl1[0]);
                $datefrom2 = date("M-Y", mktime(0, 0, 0, $tanggal[1], $tanggal[2], $tanggal[0]));
                $valHad5 = $datefrom2;
            }
            $timec[] = $valHad5;
        }
        
        $db = Yii::$app->params['tujuan'];

        foreach ($db as $key0 => $value0) {
            $tujuan = $value0;
            foreach ($timec as $key => $value) {
                $data[$tujuan][$value] = 0;
            }
        }

        foreach ($db as $key => $value) {
            $tujuan_name = $value;
            $tujuan_key = $key;
            $sqlPt = "SELECT DATE_FORMAT(td_tgl_daftar,'%Y-%m-%d') as tanggal, td_id, td_tujuan from tbl_daftar where flag_deleted=0 AND td_tujuan='".$key."' AND td_tgl_daftar BETWEEN '".$start."' and '".$stop."'";
            
            $dbPt = Yii::$app->db->createCommand($sqlPt)->queryAll();
            
            foreach ($dbPt as $keyPt => $valuePt) {
                if($valuePt['td_tujuan'] == $key){
                        if ($type == 5) {
                            $tgl1 = explode(' ', $valuePt['tanggal']);
                            $tanggal = explode('-', $tgl1[0]);
                            $datefrom3 = date("M-Y", mktime(0, 0, 0, $tanggal[1], $tanggal[2], $tanggal[0]));
                            $valHad6 = $datefrom3;
                        }
                        if($data[$tujuan_name][$valHad6] == 0){
                            $sum = 1;
                        }else{
                            $sum++;
                        }
                        $data[$tujuan_name][$valHad6] = $sum;
                }
            }
        }
// die();
        foreach ($data as $keyF => $valueF) {
            foreach ($valueF as $keyFF => $valueFF) {
                $dapathp[$keyF] += $valueFF;   
            }
            // unset($dapathp);
        }
        foreach ($dapathp as $keysa => $vakye) {            
            // die();
            $datas[]=[$keysa, $vakye];
        }
        $dataH=['type' => 'pie', "name"=>$keyF, "data"=>$datas];

        // $test = [ // new opening bracket
        //         'type' => 'pie',
        //         'name' => 'Elements',
        //         'data' => [
        //             ['Firefox', 45.0],
        //             ['IE', 26.8],
        //             ['Safari', 8.5],
        //             ['Opera', 6.2],
        //             ['Others', 0.7]
        //         ],
        //     ]; // new closing bracket

        $judulping = array('text' => 'Total Campaign');
        
        echo json_encode(["data"=> $dataH , "xaxis"=>$timec , "title"=>"Registration by Category","yaxis"=>$judulping]);
        die();
        // echo $hasil;
    }
    public function actionDiagram4(){
        $start = date('Y-m-d H:00:00', strtotime($_GET['start']));
        $stop = date('Y-m-d H:59:59', strtotime($_GET['stop']));

        $type = 5; 
        $time  = $this->getListTanggal($start,$stop,$type);
        foreach($time as $idHad5=>$valHad5){
            if ($type == 5) {
                $tgl1 = explode(' ', $valHad5);
                $tanggal = explode('-', $tgl1[0]);
                $datefrom2 = date("M-Y", mktime(0, 0, 0, $tanggal[1], $tanggal[2], $tanggal[0]));
                $valHad5 = $datefrom2;
            }
            $timec[] = $valHad5;
        }
        
        $db = Yii::$app->params['dashboard_status2'];

        foreach ($db as $key0 => $value0) {
            $tujuan = $value0;
            foreach ($timec as $key => $value) {
                $data[$tujuan][$value] = 0;
            }
        }

        foreach ($db as $key => $value) {
            $tujuan_name = $value;
            $tujuan_key = $key;
            $sqlPt = "SELECT DATE_FORMAT(first_date_frontend,'%Y-%m-%d') as tanggal, tpt_flag_status from tbl_persetujuan_tindak where flag_deleted=0 AND tpt_flag_status='".$key."' AND first_date_frontend BETWEEN '".$start."' and '".$stop."'";
            
            $dbPt = Yii::$app->db->createCommand($sqlPt)->queryAll();
            
            foreach ($dbPt as $keyPt => $valuePt) {
                if($valuePt['tpt_flag_status'] == $key){
                        if ($type == 5) {
                            $tgl1 = explode(' ', $valuePt['tanggal']);
                            $tanggal = explode('-', $tgl1[0]);
                            $datefrom3 = date("M-Y", mktime(0, 0, 0, $tanggal[1], $tanggal[2], $tanggal[0]));
                            $valHad6 = $datefrom3;
                        }
                        if($data[$tujuan_name][$valHad6] == 0){
                            $sum = 1;
                        }else{
                            $sum++;
                        }
                        $data[$tujuan_name][$valHad6] = $sum;
                }
            }
        }
// die();
        foreach ($data as $keyF => $valueF) {
            foreach ($valueF as $keyFF => $valueFF) {
                $dapathp[$keyF] += $valueFF;   
            }
            // unset($dapathp);
        }
        foreach ($dapathp as $keysa => $vakye) {            
            // die();
            $datas[]=[$keysa, $vakye];
        }
        $dataH=['type' => 'pie', "name"=>$keyF, "data"=>$datas];

        $judulping = array('text' => 'Total Campaign');
        
        echo json_encode(["data"=> $dataH , "xaxis"=>$timec , "title"=>"Persetujuan by Status","yaxis"=>$judulping]);
        die();
        // echo $hasil;
    }

    public function getListTanggal($dateFrom,$dateTo,$type = null) { ///type 1=hourly 2=minutely 3=5minutely 4=weekly 5=monthly default=daily(yyyy-mm-dd)
        $dateList = array();
        $datefrom2 = $dateFrom;
        $dateto2 = $dateTo;
        if ($type == 5) {
          $tgl1 = explode(' ', $dateFrom);
          $tanggal = explode('-', $tgl1[0]);
          $datefrom2 = date("Y-m-d", mktime(0, 0, 0, $tanggal[1], 1, $tanggal[0]));
        }
        while($datefrom2 <= $dateto2){
            //echo "<BR>".$datefrom2;
            $dateList[] = $datefrom2;
            if($type == 1){
                $dodo = explode (" ",$datefrom2);
                $date1 = explode("-",$dodo[0]);
                $date2 = explode(":",$dodo[1]);
            }
            else{
                $date1 = explode("-",$datefrom2);
            }
                
            if($type == 1){
                $datefrom2 = date("Y-m-d H:00", mktime(intval($date2[0])+1, 0, 0, $date1[1], $date1[2], $date1[0]));
            }
            else if($type == 2){
                $datefrom2 = date("Y-m-d H:i:00", mktime(intval($date2[0]), intval($date2[1])+1, 0, $date1[1], $date1[2], $date1[0]));
            }
            else if($type == 3){
                $datefrom2 = date("Y-m-d H:i:00", mktime(intval($date2[0]), intval($date2[1])+5, 0, $date1[1], $date1[2], $date1[0]));
            }
            else if($type == 4){
                // $datefrom2 = date("Y-m-d 00:00:00", mktime(0, 0, 0, $date1[1], intval($date1[2])+7, $date1[0]));
                $datefrom2 = date("Y-m-d", mktime(0, 0, 0, $date1[1], intval($date1[2])+7, $date1[0]));
            }
            else if($type == 5){
                // $datefrom2 = date("Y-m", mktime(0, 0, 0, intval($date1[1])+1, $date1[2], $date1[0]));
                // $datefrom2 = date("Y-m-d", mktime(0, 0, 0, intval($date1[1])+1, $date1[2], $date1[0]));
                $datefrom2 = date("Y-m-d", mktime(0, 0, 0, intval($date1[1])+1, 1, $date1[0]));
                // $datefrom2 = date("Y-m", mktime(0, 0, 0, intval($date1[1])+1, $date1[0]));
            }
            else
                $datefrom2 = date("Y-m-d", mktime(0, 0, 0, $date1[1], intval($date1[2])+1, $date1[0]));
        }
        return $dateList;
    }

    /**
     * Displays a single Dashboard model.
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
     * Creates a new Dashboard model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Dashboard();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ttd_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Dashboard model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->ttd_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Dashboard model.
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
     * Finds the Dashboard model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Dashboard the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Dashboard::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
