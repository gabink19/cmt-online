<?php

namespace backend\controllers;

use Yii;
use backend\models\User;
use backend\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends MainController 
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();


        if ($model->load(Yii::$app->request->post())){
            $pass = $model->password_hash;
            $pass1 = $_POST['User']['password_hash1'];
            $model->password_hash = Yii::$app->security->generatePasswordHash($model->password_hash);
            $model->password_hash1 = Yii::$app->security->generatePasswordHash($_POST['User']['password_hash1']);
            $model->auth_key = Yii::$app->security->generateRandomString();
            $model->created_at = strtotime(date('Y-m-d H:i:s'));
            $model->updated_at = strtotime(date('Y-m-d H:i:s'));
			 $model->active_date = date('Y-m-d H:i:s', strtotime('now'));
          /*  $model->active_date = strtotime(date('Y-m-d H:i:s'));*/
            if($model->type_user==0){
                $model->bidang_mitra = $model->bidang_user;
            }else{
                $model->bidang_user = $model->bidang_mitra;
            }
            if ($pass != $pass1) {
                $model->addError('password_hash1', 'Password tidak sama,cek kembali');
            }
            if ($model->validate()) {
                if($model->save()) {
                    // return $this->redirect(['view', 'id' => $model->id]);
                    return $this->redirect(['index']);
                }
            }
            $model->password_hash = $pass;
            $model->password_hash1 = $pass1;
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelOld = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())){
            $pass = $model->password_hash;
            $pass1 = $_POST['User']['password_hash1'];

            if ($pass!=$modelOld->password_hash) {
                $model->password_hash = Yii::$app->security->generatePasswordHash($model->password_hash);
                $model->password_hash1 = Yii::$app->security->generatePasswordHash($_POST['User']['password_hash1']);
                $model->auth_key = Yii::$app->security->generateRandomString();
                $model->updated_at = strtotime(date('Y-m-d H:i:s'));
                if ($pass != $pass1) {
                    $model->addError('password_hash1', 'Password tidak sama,cek kembali');
                }
            }
            if($model->type_user==0){
                $model->bidang_mitra = $model->bidang_user;
            }else{
                $model->bidang_user = $model->bidang_mitra;
            }
            // echo "<pre>"; print_r($model);echo "</pre>";die();
            if ($model->validate()) {
                if($model->save()) {
                    // return $this->redirect(['view', 'id' => $model->id]);
                    return $this->redirect(['index']);
                }
            }
            $model->password_hash = $pass;
            $model->password_hash1 = $pass1;
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing User model.
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
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
