<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Peserta;
use frontend\models\PesertaSearch;
use yii\web\Controller;
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

    /**
     * Lists all Peserta models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PesertaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

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
            if ($model->save()) {
                // return $this->redirect(['view', 'tp_id' => $model->tp_id, 'tp_nikes' => $model->tp_nikes]);

                return $this->redirect(['index']);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
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

        if ($model->load(Yii::$app->request->post())) {
            $model->tp_flag_active=1;
            if ($model->save()) {
                // return $this->redirect(['view', 'tp_id' => $model->tp_id, 'tp_nikes' => $model->tp_nikes]);
                return $this->redirect(['index']);
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
            return $this->redirect(['index']);
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
