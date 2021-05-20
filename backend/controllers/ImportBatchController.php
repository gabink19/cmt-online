<?php

namespace backend\controllers;

use Yii;
use backend\models\ImportBatch;
use backend\models\ImportBatchSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ImportBatchController implements the CRUD actions for ImportBatch model.
 */
class ImportBatchController extends MainController 
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
     * Lists all ImportBatch models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ImportBatchSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = new ImportBatch();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model' => $model,
        ]);
    }

    public function actionUpload()
    {
        if (isset($_FILES['ImportBatch'])) {
            $date = date('YmdHis');
            // $explode = explode(PHP_EOL, file_get_contents());
            $session = Yii::$app->session;
            $user = $session->get('user');
            $model = new ImportBatch();
            $model->tib_filename = $date.'_'.$_FILES['ImportBatch']['name']['tib_filename'];
            $model->tib_status = 0;
            $model->tib_date = date('Y-m-d H:i:s',strtotime($date));
            $model->first_user = @$user->username;

            $upload = rename($_FILES['ImportBatch']['tmp_name']['tib_filename'], Yii::$app->params['pathImport'].$model->tib_filename);
            if ($upload && $model->save()) {
                Yii::$app->session->set('notif','Import');
                return $this->redirect(['index']);
            }else{
                return $this->redirect(['index']);
            }
        }
    }
    /**
     * Displays a single ImportBatch model.
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
     * Creates a new ImportBatch model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ImportBatch();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->tib_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ImportBatch model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->tib_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ImportBatch model.
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
     * Finds the ImportBatch model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ImportBatch the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ImportBatch::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
