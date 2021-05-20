<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Bidang;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(['id'=>'userForm']); ?>
    <div class="row">
        <div class="col-md-8">
            <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-8">
            <?= $form->field($model, 'password_hash')->textInput(['maxlength' => true,'type'=>'password'])->label('Password') ?>
        </div>
        <div class="col-md-8">
            <?= $form->field($model, 'password_hash1')->textInput(['maxlength' => true,'type'=>'password'])->label('Ketik Ulang Password') ?>
        </div>
        <div class="col-md-8">
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-8">
            <?= $form->field($model, 'no_telp')->textInput(['maxlength' => true]) ?>
        </div>


        <div class="col-md-8">
            <?= $form->field($model, 'type_user')->dropDownList(
                Yii::$app->params['typeUser'], 
                ['prompt'=>'Pilih Type User...','onchange'=>'typeUser();']);
            ?>
        </div>

        <div class="col-md-8" name='backend[]'>
            <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-8" name='backend[]'>
            <?= $form->field($model, 'bidang_user')->dropDownList(
                ArrayHelper::map(Bidang::find()->select(['tb_id', 'tb_nama_bidang'])->all(), 'tb_id', 'tb_nama_bidang'), 
                ['prompt'=>'Pilih Bidang...']);
            ?>
        </div>

        <div class="col-md-8" name='frontend[]'>
            <?= $form->field($model, 'rs_mitra')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-8" name='frontend[]'>
            <?= $form->field($model, 'bidang_mitra')->dropDownList(
                ArrayHelper::map(Bidang::find()->select(['tb_id', 'tb_nama_bidang'])->all(), 'tb_id', 'tb_nama_bidang'), 
                ['prompt'=>'Pilih Bidang...']);
            ?>
        </div>
        <div class="col-md-8" name='frontend[]'>
            <?= $form->field($model, 'alamat_rs')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-md-8">
            <?= $form->field($model, 'flag_active')->textInput() ?>
        </div>
        <div class="col-md-8">
            <div class="form-group">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

    <!-- <?= $form->field($model, 'auth_key')->textInput(['maxlength' => true]) ?> -->

    <!-- <?= $form->field($model, 'password_hash')->textInput(['maxlength' => true]) ?> -->

    <!-- <?= $form->field($model, 'password_reset_token')->textInput(['maxlength' => true]) ?> -->


    <!-- <?= $form->field($model, 'status')->textInput() ?> -->

    <!-- <?= $form->field($model, 'created_at')->textInput() ?> -->

    <!-- <?= $form->field($model, 'updated_at')->textInput() ?> -->

    <!-- <?= $form->field($model, 'first_user')->textInput(['maxlength' => true]) ?> -->

   <!--  <?= $form->field($model, 'first_ip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'first_update')->textInput() ?>

    <?= $form->field($model, 'last_user')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'last_ip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'last_update')->textInput() ?>

    <?= $form->field($model, 'active_date')->textInput() ?>

    <?= $form->field($model, 'usermode')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'flag_multiple')->textInput() ?>

    <?= $form->field($model, 'last_action')->textInput() ?>

    <?= $form->field($model, 'ip')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'flag_login')->textInput() ?>

    <?= $form->field($model, 'lastvisit')->textInput() ?>
 -->

    <!--

    

     -->


</div>
<script type="text/javascript">
    $( document ).ready(function() {
        typeUser();
    });
    function typeUser() {
        if ($('#user-type_user').val()==''){
            $('div[name="frontend[]"]').hide();
            $('div[name="backend[]"]').hide();
        }
        else if ($('#user-type_user').val()==1) {
            $('div[name="frontend[]"]').show();
            $('div[name="backend[]"]').hide();
        }else if ($('#user-type_user').val()==0) {
            $('div[name="frontend[]"]').hide();
            $('div[name="backend[]"]').show();
        }
    }
    
</script>