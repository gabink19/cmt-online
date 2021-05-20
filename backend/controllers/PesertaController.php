<?php

namespace backend\controllers;

use Yii;
use backend\models\Peserta;
use backend\models\PesertaSearch;
use yii\web\Controller;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PesertaController implements the CRUD actions for Peserta model.
 */
class PesertaController extends MainController 
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

    public function actionSelectNikes($q = null, $id = null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = 'SELECT tp_nikes as id, tp_nikes as text FROM tbl_peserta WHERE tp_nikes like "%'.$q.'%" LIMIT 30';
            $command = Yii::$app->db->createCommand($query);
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        }
        elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => $id];
        }
        return $out;
    }


    public function actionSelectNik($q = null, $id = null) {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!is_null($q)) {
            $query = 'SELECT tp_nik as id, tp_nik as text FROM tbl_peserta WHERE tp_nik like "%'.$q.'%" LIMIT 30';
            $command = Yii::$app->db->createCommand($query);
            $data = $command->queryAll();
            $out['results'] = array_values($data);
        }
        elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'text' => $id];
        }
        return $out;
    }
    /**
     * Lists all Peserta models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PesertaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        Yii::$app->session->set('session_peserta',Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Peserta model.
     * @param integer $tp_id
     * @param string $tp_nikes
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($tp_id, $tp_nikes)
    {
        return $this->render('view', [
            'model' => $this->findModel($tp_id, $tp_nikes),
        ]);
    }

    /**
     * Creates a new Peserta model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Peserta();

        if ($model->load(Yii::$app->request->post())) {
            $model->tp_flag_active=1;
            $model->flag_deleted=1;
            if ($model->save()) {
                $attributes = $model->attributeLabels();
                $data = "";
                foreach ($model as $key => $value) {
                    $data .= $attributes[$key].":".$model->$key.",";
                }
                $activity = "[CREATE PESERTA] ".$data;
                $this->historyUser($activity,$user,$ip);
                Yii::$app->session->set('notif','Create Peserta');
                // return $this->redirect(['view', 'tp_id' => $model->tp_id, 'tp_nikes' => $model->tp_nikes]);
                if (isset($_GET['FlagMobile']) && $_GET['FlagMobile']=='true' && isset($_GET['IdUser']) && $_GET['IdUser']!='') {
                    return $this->redirect(['index','FlagMobile'=>'true','IdUser'=>$_GET['IdUser']]);
                }else{
                    return $this->redirect(['index']);
                }
            }else{
                // echo "<pre>"; print_r($model->getErrors());echo "</pre>";
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionExcel()
    {
        ini_set('memory_limit', '4095M');
        ini_set('max_execution_time', 300);
        $start = microtime(true);
        $searchModel = new PesertaSearch();
        $dataProvider = $searchModel->search(Yii::$app->session->get('session_peserta'));
        session_write_close();
        $dataProvider->pagination->pageSize  = 1000;
        $pagesize = $dataProvider->pagination->pageSize;// it will give Per Page data. 

        $total = $dataProvider->totalCount; //total records // 15 
        $dataProvider->pagination =false;
        // echo (int) (($total + $pagesize - 1) / $pagesize); 
        // $dataProvider->pagination  = false;

        header("Content-type: text/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=Data Peserta.xls");
        header("Pragma: no-cache");
        header("Expires: 0");

        unset(Yii::$app->assetManager->bundles['kartik\swtichinput']);
        // $this->layout = 'yourLayout';
        echo $this->renderPartial('excel', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
       exit;
    }


    public function actionCsv()
    {
       ini_set('memory_limit', '4095M');
       ini_set('max_execution_time', 0);
       $start = microtime(true);
       $searchModel = new PesertaSearch();
       $dataProvider = $searchModel->search(Yii::$app->session->get('session_peserta'));
       $dataProvider->pagination  = false;

        $session = Yii::$app->session;
        $golongan = $session->get('golongan');
        $golongan = ArrayHelper::map($golongan, 'tg_id', 'tg_penamaan');
       // echo "<pre>"; print_r(Yii::$app->session->get('session_peserta'));echo "</pre>";

       $header = "Data Peserta\n\n Nikes,NIK,Nama Keluarga,Tgl Lahir,Umur,Golongan,Kategori Host,Jenis Kelamin \n";
       header("Content-type: application/text-plain");
       header("Content-Disposition: attachment; filename=Data_Peserta_".date('Ymd').".csv");
       header("Pragma: no-cache");
       header("Expires: 0");
           
       echo $header;

       foreach ($dataProvider->getModels() as $key => $value) {
        $data = $value->attributes;

        echo "\"".$data['tp_nikes']."\",\"".$data['tp_nik']."\",\"".$data['tp_nama_kel']."\",\"".$data['tp_tgl_lahir']."\",\"".$data['tp_umur']."\",\"".$golongan[$data['tp_gol']]."\",\"".Yii::$app->params["kategori_host"][$data['kategori_host']]."\",\"".Yii::$app->params['jkelamin'][$data['tp_jenis_kelamin']]."\" \n";
       }

        $time = microtime(true) - $start;
        // echo $time;
       exit;
    }

    /**
     * Updates an existing Peserta model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $tp_id
     * @param string $tp_nikes
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($tp_id, $tp_nikes)
    {
        $model = $this->findModel($tp_id, $tp_nikes);
        $modelOld = $this->findModel($tp_id, $tp_nikes);

        if ($model->load(Yii::$app->request->post())) {
            $model->tp_flag_active=1;
            if ($model->save()) {
                $attributes = $model->attributeLabels();
                $data = '';
                foreach ($model as $key => $value) {
                    if ($modelOld[$key]!=$model->$key) {
                        $data .= $attributes[$key].":".$modelOld[$key]." to ".$model->$key.",";
                    }
                }
                $user = Yii::$app->user->identity->username;
                $ip = $_SERVER['REMOTE_ADDR'];
                $activity = "[UPDATE PESERTA ID : ".$id."] ".$data;
                Yii::$app->session->set('notif','Update Peserta');
                // return $this->redirect(['view', 'tp_id' => $model->tp_id, 'tp_nikes' => $model->tp_nikes]);
                if (isset($_GET['FlagMobile']) && $_GET['FlagMobile']=='true' && isset($_GET['IdUser']) && $_GET['IdUser']!='') {
                    return $this->redirect(['index','FlagMobile'=>'true','IdUser'=>$_GET['IdUser']]);
                }else{
                    return $this->redirect(['index']);
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Peserta model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $tp_id
     * @param string $tp_nikes
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($tp_id, $tp_nikes)
    {
        $model = $this->findModel($tp_id, $tp_nikes);
        // ->delete();
        $model->flag_deleted = 1;
         // ->delete();
        if($model->save(false)) {
            $attributes = $model->attributeLabels();
            $data = "";
            foreach ($model as $key => $value) {
                $data .= $attributes[$key].":".$model->$key.",";
            }
            $activity = "[DELETE PERSETUJUAN] ".$data;
            $this->historyUser($activity,$user,$ip);
            Yii::$app->session->set('notif','Delete Peserta');
            if (isset($_GET['FlagMobile']) && $_GET['FlagMobile']=='true' && isset($_GET['IdUser']) && $_GET['IdUser']!='') {
                return $this->redirect(['index','FlagMobile'=>'true','IdUser'=>$_GET['IdUser']]);
            }else{
                return $this->redirect(['index']);
            }
        }
    }

    /**
     * Finds the Peserta model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $tp_id
     * @param string $tp_nikes
     * @return Peserta the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($tp_id, $tp_nikes)
    {
        if (($model = Peserta::findOne(['tp_id' => $tp_id, 'tp_nikes' => $tp_nikes])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
