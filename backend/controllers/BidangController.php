<?php

namespace backend\controllers;

use Yii;
use backend\models\Bidang;
use backend\models\Menu;
use backend\models\BidangSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BidangController implements the CRUD actions for Bidang model.
 */
class BidangController extends MainController 
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
     * Lists all Bidang models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BidangSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Bidang model.
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
     * Creates a new Bidang model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Bidang();
        $left = [];
        $right = [];
        $all = [];
        $menu = Menu::find()->select(['id','name'])->all();
        foreach ($menu as $key => $value) {
            $id=0;
            $query = 'SELECT count(*) FROM `role_access` WHERE id_bidang='.$id.' AND id_menu="'.$value->id.'"';
            $cek = Yii::$app->db->createCommand($query)->queryScalar();
            if ($cek>0) {
                $right[$value->id] = $value->name;
            }else{
                $left[$value->id] = $value->name;
            }
            $all[$value->id] = $value->name;
        }
        if ($model->load(Yii::$app->request->post())){
            $post = Yii::$app->request->post()['Bidang'];
            $model->flag_deleted = 0;
            if ($model->save()) {
                if (!empty($post['selectmenu'])) {
                    foreach (@$post['selectmenu'] as $key => $value) {
                        $query = 'DELETE FROM `role_access` WHERE id_bidang="'.$model->tb_id.'" AND id_menu="'.$value.'"';
                        Yii::$app->db->createCommand($query)->execute();
                    }
                }
                if (!empty($post['selectedmenu'])) {
                    foreach (@$post['selectedmenu'] as $key => $value) {
                        $query = 'DELETE FROM `role_access` WHERE id_bidang="'.$model->tb_id.'" AND id_menu="'.$value.'"';
                        Yii::$app->db->createCommand($query)->execute();
                        $query = 'INSERT INTO `role_access` (id_bidang, id_menu) VALUES ('.$model->tb_id.','.$value.')';
                        Yii::$app->db->createCommand($query)->execute();
                    }
                }
                $attributes = $model->attributeLabels();
                $data = "";
                foreach ($model as $key => $value) {
                    $data .= $attributes[$key].":".$model->$key.",";
                }
                $activity = "[CREATE BIDANG] ".$data;
                $this->historyUser($activity,$user,$ip);
                Yii::$app->session->set('notif','Create Bidang');
               // return $this->redirect(['view', 'id' => $model->tb_id]);
                return $this->redirect(['index']);
            }else{
                // echo "<pre>"; print_r($model->getErrors());echo "</pre>";
            }
        }

        return $this->render('create', [
            'model' => $model,
            'left' => $left,
            'right' => $right,
            'all' => $all,
        ]);
    }

    /**
     * Updates an existing Bidang model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelOld = $this->findModel($id);
        $left = [];
        $right = [];
        $all = [];
        $menu = Menu::find()->select(['id','name'])->all();
        foreach ($menu as $key => $value) {
            $query = 'SELECT count(*) FROM `role_access` WHERE id_bidang='.$id.' AND id_menu="'.$value->id.'"';
            $cek = Yii::$app->db->createCommand($query)->queryScalar();
            if ($cek>0) {
                $right[$value->id] = $value->name;
            }else{
                $left[$value->id] = $value->name;
            }
            $all[$value->id] = $value->name;
        }
        if ($model->load(Yii::$app->request->post())){
            $post = Yii::$app->request->post()['Bidang'];
            if ($model->save()) {
                if (!empty($post['selectmenu'])) {
                    foreach (@$post['selectmenu'] as $key => $value) {
                        $query = 'DELETE FROM `role_access` WHERE id_bidang="'.$id.'" AND id_menu="'.$value.'"';
                        Yii::$app->db->createCommand($query)->execute();
                    }
                }
                if (!empty($post['selectedmenu'])) {
                    foreach (@$post['selectedmenu'] as $key => $value) {
                        $query = 'DELETE FROM `role_access` WHERE id_bidang="'.$id.'" AND id_menu="'.$value.'"';
                        Yii::$app->db->createCommand($query)->execute();
                        $query = 'INSERT INTO `role_access` (id_bidang, id_menu) VALUES ('.$id.','.$value.')';
                        Yii::$app->db->createCommand($query)->execute();
                    }
                }
                $attributes = $model->attributeLabels();
                $data = '';
                foreach ($model as $key => $value) {
                    if ($modelOld[$key]!=$model->$key) {
                        $data .= $attributes[$key].":".$modelOld[$key]." to ".$model->$key.",";
                    }
                }
                $user = Yii::$app->user->identity->username;
                $ip = $_SERVER['REMOTE_ADDR'];
                $activity = "[UPDATE BIDANG ID : ".$id."] ".$data;
                $this->historyUser($activity,$user,$ip);
                Yii::$app->session->set('notif','Update Bidang');
               // return $this->redirect(['view', 'id' => $model->tb_id]);
                return $this->redirect(['index']);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'left' => $left,
            'right' => $right,
            'all' => $all,
        ]);
    }

    /**
     * Deletes an existing Bidang model.
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
            $activity = "[DELETE BIDANG] ".$data;
            $this->historyUser($activity,$user,$ip);
            Yii::$app->session->set('notif','Hapus Bidang');
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the Bidang model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Bidang the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Bidang::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
