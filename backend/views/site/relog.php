<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Sign In';

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];

// $fieldOptions2 = [
//     'options' => ['class' => 'form-group has-feedback'],
//     'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
// ];
?>

<div class="login-box">
    <div class="login-logo">
        <img src="/image/DASHBOARD.png" width="300px">
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
        <h3 class="login-box-msg">Silahkan logout aplikasi dan Silahkan login kembali.</h3>

        <!-- <a href="#">I forgot my password</a><br>
        <a href="register.html" class="text-center">Register a new membership</a> -->

    </div>
    <!-- /.login-box-body -->
    <div class="login-logo" style="padding-top: 20px">
        <img src="/image/sponsor.png" width="200px">
    </div>
</div><!-- /.login-box -->
