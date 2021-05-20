<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

// jika buka di development paksa ke akses public 
// if ($_SERVER['HTTP_HOST'] =='10.11.11.233') 
// {
//     #header('Location: '."https://rm.icode.id/resource_management/?r=site%2Flogin");
//     header("Location: https://rm.icode.id/resource_management/?r=site%2Flogin"); /* Redirect browser */
//     exit();
// }

$this->title = 'Sign In';

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];
?>

<div class="login-box col-sm-4 col-md-offset-4 ">
<!-- <div class="login-box col-xs-6 col-xs-offset-3 col-sm-4 col-sm-offset-0"> -->
    <!-- <div class="login-logo col-md-offset-4"> -->
    <div class="login-logo">
        <!-- <a href="#"><b>BINTAN BATAM</b> TELEKOMUNIKASI</a> -->
        <!-- <a href="#"><b>RESOURCE MANAGEMENT</b></a> -->
        <!-- <a href="#"><h<b>SDP</b></a> -->
        <a href="#"><h1><?php echo Yii::$app->params['project_title']?></h1></a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body top-buffer">
        <p class="login-box-msg ">Login Form </p>

        <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>
        <?= $form->errorSummary($model,['header'=>''])?>
        <?= $form
            ->field($model, 'username', $fieldOptions1)
            ->label(false)
            ->textInput(['placeholder' => $model->getAttributeLabel('username')]) ?>

        <?= $form
            ->field($model, 'password', $fieldOptions2)
            ->label(false)
            ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>

        <div class="row">
            <div class="col-xs-8">
                <?php //$form->field($model, 'rememberMe')->checkbox() ?>
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
                <?= Html::submitButton('Sign in', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
            </div>
            <!-- /.col -->
        </div>


        <?php ActiveForm::end(); ?>       

    </div>
    <!-- /.login-box-body -->
</div><!-- /.login-box -->
