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
        <p class="login-box-msg">Sign in to start your session</p>

        <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>

        <div class="row">
            <div class="col-xs-12">
                <?= $form
                    ->field($model, 'username', $fieldOptions1)
                    ->label(false)
                    ->textInput(['placeholder' => $model->getAttributeLabel('username')]) ?>
            </div>
        </div> 
        <div class="row">
            <div class="col-xs-10" style="padding-right: 0px">
             <?= $form
                ->field($model, 'password', $fieldOptions2)
                ->label(false)
                ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>
            </div>

            <div class="col-xs-2" style="padding-left: 0px">
                <?= Html::button('<span class="glyphicon glyphicon-eye-open" id="showpassword"></span>', ['class' => 'btn btn-primary btn-block btn-flat','title' => 'Show Password','id' => 'buttonshowpass','style'=>'margin-left:0px;background-color:#6d6f72 !important;border-color:#6d6f72 !important;','onclick'=>'showPass(); return false;']) ?>
            </div>
        </div>
        
        <div class="row">
            <div class="col-xs-8">
                <?php $model->rememberMe = false; ?>
                <?= $form->field($model, 'rememberMe')->checkbox() ?>
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
                <?= Html::submitButton('Sign in', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
            </div>
            <!-- /.col -->
        </div>


        <?php ActiveForm::end(); ?>

        <!-- <a href="#">I forgot my password</a><br>
        <a href="register.html" class="text-center">Register a new membership</a> -->

    </div>
    <!-- /.login-box-body -->
    <div class="login-logo" style="padding-top: 20px">
        <img src="/image/sponsor.png" width="200px">
    </div>
</div><!-- /.login-box -->

<script type="text/javascript">
    function showPass() {
        type = $('#loginform-password').attr('type');
        if (type=='text') {
            $('#loginform-password').attr('type','password');
            $('#buttonshowpass').attr('title','Show Password');
            $('#showpassword').attr('class','glyphicon glyphicon-eye-open');
        }else{
            $('#loginform-password').attr('type','text');
            $('#buttonshowpass').attr('title','Hide Password');
            $('#showpassword').attr('class','glyphicon glyphicon-eye-close');
        }
    }
</script>