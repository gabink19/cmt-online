<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Rujukan;
use frontend\models\RujukanSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $attributes = $model->attributeLabels();
                        $data = "";
                        foreach ($model as $key => $value) {
                            $data .= $attributes[$key].":".$model->$key.",";
                        }
                        $activity = "[CREATE RUJUKAN] ".$data;
                        $this->historyUser($activity,$user,$ip);
            return $this->redirect(['view', 'id' => $model->id]);
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
        $model = $this->findModel($id);
        $modelOld = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $attributes = $model->attributeLabels();
                $data = '';
                foreach ($model as $key => $value) {
                    if ($modelOld[$key]!=$model->$key) {
                        $data .= $attributes[$key].":".$modelOld[$key]." to ".$model->$key.",";
                    }
                }
                $user = Yii::$app->user->identity->username;
                $ip = $_SERVER['REMOTE_ADDR'];
                $activity = "[UPDATE RUJUKAN ID : ".$id."] ".$data;
                $this->historyUser($activity,$user,$ip);
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
        $model = $this->findModel($id);
         // ->delete();
        if($model->delete()) { 
            $attributes = $model->attributeLabels();
            $data = "";
            foreach ($model as $key => $value) {
                $data .= $attributes[$key].":".$model->$key.",";
            }
            $activity = "[DELETE RUJUKAN] ".$data;
            $this->historyUser($activity,$user,$ip);
            Yii::$app->session->set('notif','Hapus Rujukan');
            return $this->redirect(['index']);
        }
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
