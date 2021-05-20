<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace frontend\controllers;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\Url;
use backend\models\User;
use backend\models\ActivityUser;

class MainController extends Controller {

    /**
     * Untuk cek session user
     * @return [type] [description]
     */
    public function beforeAction($action){

        if (Yii::$app->controller->action->id === 'portal' || Yii::$app->controller->action->id === 'contact' || Yii::$app->controller->action->id === 'information' || Yii::$app->controller->action->id === 'pdf') {
            return true;
        }
        if (Yii::$app->controller->action->id !== 'login') {
            if (Yii::$app->controller->action->id != 'check-notif') {
                if (isset(Yii::$app->user->identity->last_action)) {
                    $lastvisit = (Yii::$app->user->identity->last_action=='')?date('2020-m-d H:i:s'):Yii::$app->user->identity->last_action;
                    $now = date('Y-m-d H:i:s');
                    $datetime1 = new \DateTime($lastvisit);
                    $datetime2 = new \DateTime($now);
                    $interval = $datetime1->diff($datetime2);
                    $elapsed = $interval->format('%h%i');
                    $session = Yii::$app->session;
                    $session = $session->get('user');

                    // if ($elapsed>20 && $session=='') {
                        // $id = Yii::$app->user->identity->id;
                        // $model = User::findOne($id);
                        // $model->last_action = date('Y-m-d H:i:s');
                        // $model->save();
                        
                        // Yii::$app->user->logout();
                        // return $this->redirect(['site/login']);
                    // }else{
                        $id = Yii::$app->user->identity->id;
                        $model = User::findOne($id);
                        $model->last_action = date('Y-m-d H:i:s');
                        $model->save();
                    // }
                }
                
                if(Yii::$app->user->isGuest) {
                    Yii::$app->user->logout();
                    return $this->redirect(['site/login']);
                }
                $session = Yii::$app->session;
                $session = $session->get('user');
                if($session=='') {
                    Yii::$app->user->logout();
                    return $this->redirect(['site/login']);
                }
            }
        }
        if (Yii::$app->controller->action->id != 'check-notif' && Yii::$app->controller->action->id !== 'login') {
            $id = Yii::$app->user->identity->id;
            $model = User::findOne($id);
            $model->last_action = date('Y-m-d H:i:s');
            $model->save();
        }   

        return true;
    }
    public function historyUser($activity,$user='',$ip='')
    {

        $user = Yii::$app->user->identity->username;
        $ip = $_SERVER['REMOTE_ADDR'];
        if ($user!='') {
            $model = new ActivityUser;
            $model->berita = str_replace(',', ', ', rtrim($activity,','));
            $model->username = $user;
            $model->ip = $ip;
            $model->tanggal = date('Y-m-d H:i:s');
            $model->save(false);
        }
    }

    public function SendEmail($to,$from,$subject,$body,$attach='')
    {
      try{
        if ($attach != '') {
            Yii::$app->mailer->compose()
            ->setTo($to)
            ->setFrom($from)
            ->setSubject($subject)
            ->setHtmlBody($body)
            ->attach($attach)
            ->send();
        }else{
            Yii::$app->mailer->compose()
            ->setTo($to)
            ->setFrom($from)
            ->setSubject($subject)
            ->setHtmlBody($body)
            ->send();
        }
        return true;
      }catch (\Exception $e){
        error_log(date('Y-m-d H:i:s')." : [Failed Send Email] $e \n\n",3,'/home/developt/web-cmt-online/cmt-online/log/failed_email_frontend_'.date('Ymd').".log");
        return false;
      }
    }

    public function userSelf()
    {
        $session = Yii::$app->session;
        $session = $session->get('user');
        return $session['username'];
    }

    public function __call($name, $arguments)
    {
        // Note: value of $name is case sensitive.
        // echo "Calling object method '$name' ". implode(', ', $arguments). "\n";die();
    }
    public function checkAuthorizeMethod($action){

    }

}