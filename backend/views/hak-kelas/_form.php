<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use backend\models\User;

/* @var $this yii\web\View */
/* @var $model backend\models\HakKelas */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="hak-kelas-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="col-md-4">
     <?=
    $form->field($model, 'id_user')->widget(Select2::classname(), [
                        'options' => ['placeholder' => 'Select User'],
                        'hideSearch' => false,
                        'data' => ArrayHelper::map(User::find()->where(['type_user' => 1])->all(), 'id', 'username'),
                        'pluginOptions' => [
                            'allowClear' => true
                        ]
                    ]);
   
    ?>
    </div>

    <div class="col-md-4">    
    <?= $form->field($model, 'thk_rumah_sakit')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="col-md-4">    
     <?= $form->field($model, 'thk_kategori_host')->dropDownList(Yii::$app->params['kategori_host']); ?>
    </div>

    <div class="col-md-4">
    <?= $form->field($model, 'I')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="col-md-4">
    <?= $form->field($model, 'II')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="col-md-4">
    <?= $form->field($model, 'III')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="col-md-4">
    <?= $form->field($model, 'IV')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="col-md-4">
    <?= $form->field($model, 'V')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="col-md-4">
    <?= $form->field($model, 'VI')->textInput(['maxlength' => true]) ?>
    </div>

    <div class="col-md-4">
    <?= $form->field($model, 'VII')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-4">
    <?= $form->field($model, 'A')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-4">
    <?= $form->field($model, 'B')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-4">
    <?= $form->field($model, 'C')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-4">
    <?= $form->field($model, 'D')->textInput(['maxlength' => true]) ?>
    </div>


    <div class="col-md-8 form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
