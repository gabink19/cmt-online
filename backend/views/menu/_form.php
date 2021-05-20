<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Menu;
/* @var $this yii\web\View */
/* @var $model backend\models\Menu */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="menu-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-md-8">
        <?php
        if (isset($_GET['id'])) {
            echo $form->field($model, 'type_menu')->dropDownList(
                ['0' => 'Parent Menu', '1' => 'Menu', '2' => 'Crud']
                ,['prompt'=>'Pilih Type Menu...','onchange'=>'type_menu(this.value)','disabled'=>true]
            );
        }else{
            echo $form->field($model, 'type_menu')->dropDownList(
                ['0' => 'Parent Menu', '1' => 'Menu', '2' => 'Crud']
                ,['prompt'=>'Pilih Type Menu...','onchange'=>'type_menu(this.value)']
            );
        } ?>
        </div>
        <div class="col-md-8" id="name">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-8" id="parent">
            <?= $form->field($model, 'parent')->dropDownList(
                ArrayHelper::map(Menu::find()->select(['id', 'name'])->where(['<>','status', 2])->all(), 'id', 'name')
                ,['prompt'=>'Tanpa Parent']
            ); ?>
        </div>
        <div class="col-md-8" id="route">
            <?= $form->field($model, 'route')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-md-8" id="order">
            <?= $form->field($model, 'order')->textInput() ?>
        </div>
        <div class="col-md-8" id="icon">
            <?= $form->field($model, 'icon')->textInput(['maxlength' => true]) ?>
        </div>
    <div class="col-md-8 form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-success','id'=>'savebutton']) ?>
    </div>

    <?php ActiveForm::end(); ?>

    </div>
</div>
<script type="text/javascript">
    $( document ).ready(function() {
        $cek = $('#menu-type_menu').val();
        type_menu($cek);
    });
    function type_menu(val) {
        if (val=='') {
            $('#savebutton').prop('disabled',true);
            $('#name').hide();
            $('#parent').hide();
            $('#route').hide();
            $('#order').hide();
            $('#icon').hide();
        }else if (val==0) {
            $('#savebutton').prop('disabled',false);
            $('#name').show();
            $('#parent').hide();
            $('#route').hide();
            $('#order').show();
            $('#icon').show();
        }else if (val==1) {
            $('#savebutton').prop('disabled',false);            
            $('#name').show();
            $('#parent').show();
            $('#route').show();
            $('#order').show();
            $('#icon').show();
        }else if (val==2) {
            $('#savebutton').prop('disabled',false);
            $('#name').show();
            $('#parent').hide();
            $('#route').show();
            $('#order').hide();
            $('#icon').hide();
        }
    }
</script>
