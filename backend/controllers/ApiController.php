<?php

namespace backend\controllers;

header('Content-Type: application/json');
use Yii;
use backend\models\ActivityUser;
use backend\models\ActivityUserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\User;
use common\models\LoginForm;

/**
 * ActivityUserController implements the CRUD actions for ActivityUser model.
 */
class ApiController extends MainController 
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

    public function actionLogin()
    {
    	$entityBody = file_get_contents('php://input');
    	$body = json_decode($entityBody,true);
    	if (isset($body['username']) && isset($body['password'])) {
    		$post['LoginForm']['username']=$body['username'];
    		$post['LoginForm']['password']=$body['password'];
    		$post['LoginForm']['rememberMe']=0;
    		$harini = date('Y-m-d H:i:s');
	    	$model = new LoginForm();
	        if ($model->load($post) && $model->login()) {
	            $this->historyUser('[LOGIN via API]',$user,$ip);
	            $modelU = User::findOne(Yii::$app->user->identity->id);
	        	$modelU->flag_mobile = 'true';
	        	$modelU->expired_mobile = date('Y-m-d H:i:s', strtotime("+7 day", strtotime($harini)));
	        	$modelU->save(false);

		        $result['idUser'] = $modelU->id;
		        $result['status'] = 'true';
		        $result['keterangan'] = '';
		        $result['expired'] = $modelU->expired_mobile;
		        echo json_encode($result);
		        die();

	        } else {
			    $result['idUser'] = '';
			    $result['status'] = 'false';
			    $result['keterangan'] = 'username & password not match';
			    $result['expired'] = '';
			    echo json_encode($result);
			    die();
	        }
    	}else{
		    $result['idUser'] = '';
		    $result['status'] = 'false';
		    $result['keterangan'] = 'invalid data';
		    $result['expired'] = '';
		    echo json_encode($result);
		    die();
    	}
    }


    public function actionLogout()
    {
    	$entityBody = file_get_contents('php://input');
    	$body = json_decode($entityBody,true);
    	if (isset($body['username']) && isset($body['password'])) {
    		$post['LoginForm']['username']=$body['username'];
    		$post['LoginForm']['password']=$body['password'];
    		$post['LoginForm']['rememberMe']=0;
    		$harini = date('Y-m-d H:i:s');
	    	$model = new LoginForm();
	        if ($model->load($post) && $model->login()) {
	            $this->historyUser('[LOGOUT via API]',$user,$ip);
	            $modelU = User::findOne(Yii::$app->user->identity->id);
	        	$modelU->flag_mobile = 'false';
	        	// $modelU->expired_mobile = date('Y-m-d H:i:s', strtotime("+7 day", strtotime($harini)));
	        	$modelU->save(false);

		        $result['status'] = 'true';
			    $result['keterangan'] = '';
		        echo json_encode($result);
		        die();

	        } else {
			    $result['status'] = 'false';
			    $result['keterangan'] = 'username & password not match';
			    echo json_encode($result);
			    die();
	        }
    	}else{
		    $result['status'] = 'false';
		    $result['keterangan'] = 'invalid data';
		    echo json_encode($result);
		    die();
    	}
    }
    /**
     * Lists all ActivityUser models.
     * @return mixed
     */
    public function actionIndex()
    {
    	$entityBody = file_get_contents('php://input');


        $result['idUser'] = '';
        $result['status'] = 'true';
        $result['keterangan'] = '';
        $result['expired'] = '2020-03-29 12:00:00';
        echo json_encode($result);
        die();
    }

    /**
     * Displays a single ActivityUser model.
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
     * Creates a new ActivityUser model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ActivityUser();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ActivityUser model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ActivityUser model.
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
     * Finds the ActivityUser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ActivityUser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ActivityUser::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
