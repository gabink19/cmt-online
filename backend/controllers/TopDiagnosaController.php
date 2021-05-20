<?php

namespace backend\controllers;

use Yii;
use backend\models\TopDiagnosa;
use backend\models\TopDiagnosaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;

/**
 * TopDiagnosaController implements the CRUD actions for TopDiagnosa model.
 */
class TopDiagnosaController extends MainController 
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
     * Lists all TopDiagnosa models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new TopDiagnosaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single TopDiagnosa model.
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
     * Creates a new TopDiagnosa model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TopDiagnosa();

        if ($model->load(Yii::$app->request->post())) {
            $kode = $model->ttd_tdg_kode;
            $jumlah = count($kode);
            if($jumlah < 6){
                $model->addError('ttd_tdg_kode',"Kode must be selected at least is SIX!");
                return $this->render('create', [
                    'model' => $model,
                ]);

            }
            $model->ttd_tdg_kode = implode(",", $kode);
            $model->save();
            $attributes = $model->attributeLabels();
            $data = "";
            foreach ($model as $key => $value) {
                $data .= $attributes[$key].":".$model->$key.",";
            }
            $activity = "[CREATE TOPDIAGNOSA] ".$data;
            $this->historyUser($activity,$user,$ip);
            return $this->redirect(['view', 'id' => $model->ttd_id]);
        }
        $sql = "SELECT tdg_kode, tdg_penamaan FROM tbl_diagnosa WHERE flag_deleted=0";
        $db = Yii::$app->db->createCommand($sql)->queryAll();

        foreach ($db as $key => $value) {
            $diagnosa[$value['tdg_kode']]=$value['tdg_kode']."-".$value['tdg_penamaan'];
        }

        return $this->render('create', [
            'model' => $model,
            'diagnosa'=>$diagnosa
        ]);
    }

    /**
     * Updates an existing TopDiagnosa model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelOld = $this->findModel($id);
        $kode = explode(",", $model->ttd_tdg_kode);
        $model->ttd_tdg_kode = $kode;

        if ($model->load(Yii::$app->request->post())) {
            $kode = $model->ttd_tdg_kode;
            $jumlah = count($kode);
            if($jumlah < 6){
                $model->addError('ttd_tdg_kode',"Kode must be selected at least is SIX!");
                return $this->render('create', [
                    'model' => $model,
                ]);

            }
            $model->ttd_tdg_kode = implode(",", $kode);
            $model->save();
            $attributes = $model->attributeLabels();
            $data = '';
            foreach ($model as $key => $value) {
                if ($modelOld[$key]!=$model->$key) {
                    $data .= $attributes[$key].":".$modelOld[$key]." to ".$model->$key.",";
                }
            }
            $user = Yii::$app->user->identity->username;
            $ip = $_SERVER['REMOTE_ADDR'];
            $activity = "[UPDATE TopDiagnosa ID : ".$id."] ".$data;
            $this->historyUser($activity,$user,$ip);
            return $this->redirect(['view', 'id' => $model->ttd_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing TopDiagnosa model.
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
            $activity = "[DELETE TOPDIAGNOSA] ".$data;
            $this->historyUser($activity,$user,$ip);
            Yii::$app->session->set('notif','Delete Data');
            return $this->redirect(['index']);
        }
    }
    public function actionCari()
    {
        $kata = $_GET['start'];
        $sql = "SELECT tdg_kode, tdg_penamaan FROM tbl_diagnosa WHERE flag_deleted=0 AND tdg_kode LIKE '%".$kata."%' OR tdg_penamaan LIKE '%".$kata."%'";
        $db = Yii::$app->db->createCommand($sql)->queryAll();
        $diagnosa ="";
        foreach ($db as $key => $value) {
            // $diagnosa[$value['tdg_kode']]=$value['tdg_kode']."-".$value['tdg_penamaan'];
            // $diagnosa .= Html::tag('option',Html::encode($value['tdg_kode']),array('value'=>$value['tdg_kode']."-".$value['tdg_penamaan']),true);
            $diagnosa .= '<label>
                <input type="checkbox" name="TopDiagnosa[ttd_tdg_kode][]" value='.$value['tdg_kode'].'>'.$value['tdg_kode'].'-'.$value['tdg_penamaan'].'
            </label><br>';
        }
        
        // $hasil = ['flag'=>$flag, 'data'=>$diagnosa];
        echo $diagnosa;
        die();
    }

    /**
     * Finds the TopDiagnosa model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TopDiagnosa the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TopDiagnosa::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
