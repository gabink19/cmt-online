<?php

namespace backend\controllers;

use Yii;
use backend\models\BillingFinal;
use backend\models\Notifikasi;
use backend\models\BillingFinalSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\filters\VerbFilter;

/**
 * BillingFinalController implements the CRUD actions for BillingFinal model.
 */
class BillingFinalController extends MainController 
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

    public function uploadFile($tempName,$fileName) 
    {
        $explodeFile = explode('.',$fileName);
        $fileName = $explodeFile[0].'_'.date("Y-m-d_H:i:s").'.'.end($explodeFile);
        // shell_exec('chmod 777 -R '.Yii::$app->params['pathPermintaan']);
        // chmod(Yii::$app->params['pathPermintaan'], 0777);
        // echo "<pre>"; print_r(getcwd());echo "</pre>";die();
        if (!move_uploaded_file($tempName, Yii::$app->params['pathPendaftaran'] . $fileName)) {
            return '';
        }
        return Yii::$app->params['pathPendaftaran'] .$fileName;
    }
    /**
     * Lists all BillingFinal models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BillingFinalSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

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
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    public function actionDaftar($nikes,$td_id='')
    {
        $data = 'SELECT * FROM tbl_daftar WHERE td_tp_nikes="'.$nikes.'" and td_id="'.$td_id.'" and flag_deleted=0 order by td_id LIMIT 1';
        $result = Yii::$app->db->createCommand($data)->queryOne();

        $session = Yii::$app->session;
        $jenis_peserta = $session->get('jenis_peserta');
        $result['jenis_peserta'] =  @ArrayHelper::map($jenis_peserta, 'tjp_id', 'tjp_penamaan')[$result['td_tp_jenis_peserta']];
        return json_encode($result);
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
                    $model->tbs_path_billing = $this->uploadFile($tmp_name,$name);
                    $model->tbs_id_user_backend = Yii::$app->user->identity->id;
                    $model->tgl_billing = date('Y-m-d H:i:s');
                    $model->first_ip_backend = $_SERVER['REMOTE_ADDR'];
                    $model->first_date_backend = date('Y-m-d H:i:s');
                    $model->first_user_backend = Yii::$app->user->identity->username;
                    $model->flag_deleted = 0;
                    if ($model->save()) {

                            $query = 'UPDATE tbl_daftar SET td_flag_status="5" WHERE td_id = "'.$model->tbs_td_id.'" AND td_tp_nikes="'.$model->tbs_tp_nikes.'" AND flag_deleted="0"' ;
                            $result = Yii::$app->db->createCommand($query)->execute();

                        // $modelNotif = new Notifikasi();
                        // $modelNotif->tn_user_mitra = $model->tbs_id_user_backend;
                        // $modelNotif->tn_tanggal = date('Y-m-d H:i:s');
                        // $modelNotif->tn_judul = 'Biling Final';
                        // $modelNotif->tn_teks = 'Biling Final pada nikes '.$model->tbs_tp_nikes.' : '. @Yii::$app->params['persetujuan'][$model->tbs_flag_status];
                        // $modelNotif->tn_type_notif = 1;
                        // $modelNotif->tn_telah_dikirim = 1;
                        // $modelNotif->tn_telah_dibaca = 0;
                        // $modelNotif->tn_jenis_kegiatan = 2;
                        // $modelNotif->tn_link = str_replace('backend', 'frontend', Url::to(['billing-final/view', 'id' => $model->tbs_id]));
                        // $modelNotif->tn_user_id = Yii::$app->user->id;
                        // $modelNotif->save(false);

                        Yii::$app->session->set('notif','Create Billing');
                        // return $this->redirect(['view', 'id' => $model->tbs_id]);
                        if (isset($_GET['FlagMobile']) && $_GET['FlagMobile']=='true' && isset($_GET['IdUser']) && $_GET['IdUser']!='') {
                            return $this->redirect(['index','FlagMobile'=>'true','IdUser'=>$_GET['IdUser']]);
                        }else{
                            return $this->redirect(['index']);
                        }
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
     * Updates an existing BillingFinal model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $rowOld = $this->findModel($id);

        $url = 'billing-final%2Fupdate&id='.$id;
        $query = 'UPDATE tbl_notifikasi SET tn_telah_dibaca="1",tn_dibaca_tanggal="'.date('Y-m-d H:i:s').'" WHERE tn_type_notif="0" AND tn_telah_dikirim="1" AND tn_telah_dibaca="0" AND flag_deleted="0" AND tn_link LIKE "%'.$url.'%"' ;
        // echo "<pre>"; print_r($query);echo "</pre>";die();
        $result = Yii::$app->db->createCommand($query)->execute();

        if ($model->load(Yii::$app->request->post())) {
            $model->tbs_id_user_backend = Yii::$app->user->identity->id;
            $model->tgl_billing_diresponse = date('Y-m-d H:i:s');
            $model->first_ip_backend = $_SERVER['REMOTE_ADDR'];
            $model->first_date_backend = date('Y-m-d H:i:s');
            $model->first_user_backend = Yii::$app->user->identity->username;
            $model->flag_deleted = 0;
            $model->tbs_biaya = str_replace('.', '', $model->tbs_biaya);
            if ($model->save()) {
                $query = 'UPDATE tbl_daftar SET td_flag_status="'.Yii::$app->params['statusDaftar'][$model->tbs_flag_status].'" WHERE td_id = "'.$model->tbs_td_id.'" AND td_tp_nikes="'.$model->tbs_tp_nikes.'" AND flag_deleted="0"' ;
                $result = Yii::$app->db->createCommand($query)->execute();

                $attributes = $model->attributeLabels();
                $data = '';
                foreach ($model as $key => $value) {
                    if ($rowOld[$key]!=$model->$key) {
                        $data .= $attributes[$key].":".$rowOld[$key]." to ".$model->$key.",";
                    }
                }
                $user = Yii::$app->user->identity->username;
                $ip = $_SERVER['REMOTE_ADDR'];
                $activity = "[UPDATE BILLING FINAL ID : ".$id."] ".$data;
                $this->historyUser($activity,$user,$ip);

                $modelNotif = new Notifikasi();
                $modelNotif->tn_user_mitra = $model->tbs_id_user_backend;
                $modelNotif->tn_tanggal = date('Y-m-d H:i:s');
                $modelNotif->tn_judul = 'Biling Final';
                $modelNotif->tn_teks = 'Biling Final pada nikes '.$model->tbs_tp_nikes.' : '. @Yii::$app->params['persetujuan'][$model->tbs_flag_status];
                $modelNotif->tn_type_notif = 1;
                $modelNotif->tn_telah_dikirim = 1;
                $modelNotif->tn_telah_dibaca = 0;
                $modelNotif->tn_jenis_kegiatan = 2;
                $modelNotif->tn_link = str_replace('backend', 'frontend', Url::to(['billing-final/view', 'id' => $model->tbs_id]));
                $modelNotif->tn_user_id = Yii::$app->user->id;
                $modelNotif->save(false);
                Yii::$app->session->set('notif','Update Billing');
                // return $this->redirect(['view', 'id' => $model->tbs_id]);
                if (isset($_GET['FlagMobile']) && $_GET['FlagMobile']=='true' && isset($_GET['IdUser']) && $_GET['IdUser']!='') {
                    return $this->redirect(['index','FlagMobile'=>'true','IdUser'=>$_GET['IdUser']]);
                }else{
                    return $this->redirect(['index']);
                }
            }else{
                // echo "<pre>"; print_r($model->getErrors());echo "</pre>";
            }
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
