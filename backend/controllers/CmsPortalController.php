<?php

namespace backend\controllers;

use Yii;
use backend\models\CmsPortal;
use backend\models\CmsPortalSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CmsPortalController implements the CRUD actions for CmsPortal model.
 */
class CmsPortalController extends MainController 
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
     * Lists all CmsPortal models.
     * @return mixed
     */
    public function actionIndex()
    {
        // $searchModel = new CmsPortalSearch();
        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // return $this->render('index', [
        //     'searchModel' => $searchModel,
        //     'dataProvider' => $dataProvider,
        // ]);
        return $this->redirect(['update','id'=>1]);
    }

    /**
     * Displays a single CmsPortal model.
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
     * Creates a new CmsPortal model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        return $this->redirect(['update','id'=>1]);

        $model = new CmsPortal();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function uploadFile($tempName,$fileName,$key) 
    {
        if (strpos($key, 'banner')===0) {
            $path = Yii::$app->params['pathBanner'];
        }else if (strpos($key, 'deskripsi')===0) {
            $path = Yii::$app->params['pathDeskripsi'];
        }else if (strpos($key, 'partner')===0) {
            $path = Yii::$app->params['pathPartner'];
        }
        $exist = glob($path.$key."*");
        if (!empty($exist)) {
            foreach ($exist as $key => $value) {
                unlink($value);
            }
        }
        if (!move_uploaded_file($tempName, $path.$fileName)) {
            return '';
        }

        // 'pathBanner' => '/home/developt/web-cmt-online/cmt-online/frontend/web/portal/img/cms/banner/',
        // 'pathDeskripsi' => '/home/developt/web-cmt-online/cmt-online/frontend/web/portal/img/cms/deskripsi/',
        // 'pathPartner' => '/home/developt/web-cmt-online/cmt-online/frontend/web/portal/img/cms/partner/',
        return $fileName;
    }

    /**
     * Updates an existing CmsPortal model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id='1')
    {
        $model = $this->findModel($id);
        $modelLama = $this->findModel($id);
        $session = Yii::$app->session;
        $user = $session->get('user');
        $model->last_update=date('Y-m-d H:i:s');
        $model->last_user=$user->username;
        if ($model->load(Yii::$app->request->post())){
            foreach ($_FILES['CmsPortal']['name'] as $key => $value) {
                $tmp_name = $_FILES['CmsPortal']['tmp_name'][$key];
                $name = $_FILES['CmsPortal']['name'][$key];
                if ($name!='') {
                    $fileExplode = explode('.', $name);
                    $fileExtensions = end($fileExplode);
                    $name = $key.'.'.$fileExtensions;
                    if (strtolower($fileExtensions) =='jpg' || strtolower($fileExtensions) =='jpeg' || strtolower($fileExtensions) =='png') {
                        $model->$key = $this->uploadFile($tmp_name,$name,$key);
                    }
                }else{
                    $model->$key = $modelLama->$key;
                }
            }
            $model->save();
            $data = '';
            foreach ($model as $key => $value) {
                if ($modelLama[$key]!=$model->$key) {
                    $data .= $attributes[$key].":".$modelLama[$key]." to ".$model->$key.",";
                }
            }
            $user = Yii::$app->user->identity->username;
            $ip = $_SERVER['REMOTE_ADDR'];
            $activity = "[UPDATE PORTAL] ".$data;
            $this->historyUser($activity,$user,$ip);
            // Yii::$app->session->set('notif','Update Portal');
            echo json_encode('Success');
            die();
            // return $this->redirect(['update','id'=>1]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing CmsPortal model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {

        return $this->redirect(['update','id'=>1]);
        
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CmsPortal model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CmsPortal the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CmsPortal::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
