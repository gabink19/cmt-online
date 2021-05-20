<?php

namespace backend\controllers;

use Yii;
use backend\models\HrHost;
use backend\models\HrHostSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * HrHostController implements the CRUD actions for HrHost model.
 */
class HrHostController extends MainController 
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
     * Lists all HrHost models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new HrHostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single HrHost model.
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
     * Creates a new HrHost model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new HrHost();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $attributes = $model->attributeLabels();
            $data = "";
            foreach ($model as $key => $value) {
                $data .= $attributes[$key].":".$model->$key.",";
            }
            $activity = "[CREATE HrHost] ".$data;
            $this->historyUser($activity,$user,$ip);
            return $this->redirect(['index']);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing HrHost model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $rowOld = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
                $attributes = $model->attributeLabels();
                $data = '';
                foreach ($model as $key => $value) {
                    if ($rowOld[$key]!=$model->$key) {
                        $data .= $attributes[$key].":".$rowOld[$key]." to ".$model->$key.",";
                    }
                }
                $user = Yii::$app->user->identity->username;
                $ip = $_SERVER['REMOTE_ADDR'];
                $activity = "[UPDATE HrHost ID : ".$id."] ".$data;
                $this->historyUser($activity,$user,$ip);
            return $this->redirect(['index']);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing HrHost model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        // ->delete();
        $model->flag_deleted = 1;
         // ->delete();
        if($model->save(false)) {
            $attributes = $model->attributeLabels();
            $data = "";
            foreach ($model as $key => $value) {
                $data .= $attributes[$key].":".$model->$key.",";
            }
            $activity = "[DELETE HrHost] ".$data;
            $this->historyUser($activity,$user,$ip);
            Yii::$app->session->set('notif','Delete Data');
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the HrHost model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return HrHost the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HrHost::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
