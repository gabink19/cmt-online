<?php

namespace backend\controllers;

use Yii;
use backend\models\Rujukan;
use backend\models\RujukanSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\mpdf\Pdf;

/**
 * RujukanController implements the CRUD actions for Rujukan model.
 */
class RujukanController extends MainController 
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

    public function actionPeserta($td_id)
    {

        $session = Yii::$app->session;
        $user = $session->get('user');
    	$band =  ArrayHelper::map($session->get('band'), 'tbp_id', 'tbp_penamaan');

        $data = 'SELECT * FROM tbl_daftar WHERE td_id="'.$td_id.'"';
        $data_pendaftaran = Yii::$app->db->createCommand($data)->queryOne();

        $data = 'SELECT * FROM tbl_peserta WHERE tp_nikes="'.$data_pendaftaran['td_tp_nikes'].'"';
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
        if ($result['kategori_host']==1) {
        	$result['kategori_host'] = 'PENSIUN';
        }else{
        	$result['kategori_host'] = 'PEGAWAI';
        }
        $result['data_pendaftaran'] = $data_pendaftaran;
        $result['data_pendaftaran']['anamnese'] = 'Telah dirawat sejak tanggal '.$data_pendaftaran['td_tgl_daftar'];
        $result['data_pendaftaran']['td_tujuan'] = Yii::$app->params['tujuan'][$data_pendaftaran['td_tujuan']];
        $result['data_pendaftaran']['no_rujukan'] = date('Y').'/'.date('m').'/'.date('d').'/'.substr(hexdec(uniqid()),0,5);
        return json_encode($result);
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
    public function actionPdf($id='',$td_id='')
    {
    	$path = Yii::$app->params['pathRujukan'];
    	$filename = $path.date('Y').'/'.date('m').'/'.$td_id.'_rujukan.pdf';
    	if (file_exists($filename)) {
    	 	unlink($filename);
    	}
        shell_exec("/usr/local/bin/wkhtmltopdf --page-size 'A4' --orientation 'landscape' --page-width '1024' --enable-javascript --encoding 'UTF-8'  'https://cmt-online.site/backend/index.php?r=site%2Fpdf&id=".$id."' '".$filename."'");
    }
    /**
     * Lists all Rujukan models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RujukanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Rujukan model.
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
     * Creates a new Rujukan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Rujukan();

        if ($model->load(Yii::$app->request->post())) {
            $newDate = date("Y-m-d", strtotime($model->tr_tgl_rujukan));
            $model->tr_tgl_rujukan = $newDate;
            $model->date_create = date("Y-m-d H:i:s");
    		$path = Yii::$app->params['pathRujukan'];
            $model->path_file =$path.date('Y').'/'.date('m').'/'.$model->tr_td_id.'_rujukan.pdf';
            if ($model->save()) {
                $attributes = $model->attributeLabels();
                $data = "";
                foreach ($model as $key => $value) {
                    $data .= $attributes[$key].":".$model->$key.",";
                }
                $activity = "[CREATE RUJUKAN] ".$data;
                $this->historyUser($activity,$user,$ip);
            	$this->actionPdf($model->id,$model->tr_td_id);
				Yii::$app->session->set('notif','Create Rujukan');
                return $this->redirect(['/pendaftaran/index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Rujukan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        throw new NotFoundHttpException('The requested page does not exist.');
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Rujukan model.
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
     * Finds the Rujukan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Rujukan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Rujukan::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
