<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Bidang */
/* @var $form yii\widgets\ActiveForm */
?>
<script src="js/crossover.js"></script>
<style type="text/css">
	select[multiple], select[size] {
	    height: 200px;
	}
</style>
<div class="bidang-form">

    <?php $form = ActiveForm::begin(['id'=>'bidang-fform']); ?>
<div class="row">
        <div class="col-md-8">
        		<?= $form->field($model, 'tb_nama_bidang') ?>
        </div>
        <div class="col-md-8">
        		<?= $form->field($model, 'tb_keterangan') ?>
        </div>
        <div class="col-md-8">
        		<?= $form->field($model, 'tb_flag_akses')->dropDownList(
        		    Yii::$app->params['typeUser'], 
        		    ['prompt'=>'Pilih Type User...']);
        		?>
        </div>
        <div style="display: none;">
        	<?php 
        	echo $form->field($model, 'selectmenu')            
		     ->dropDownList($all,
		     [
		      'multiple'=>'multiple',
		      'id'=> 'bayangan',             
		     ]             
		    ); 
        	?>
        </div>
        <div class="col-md-5">
        	<?php 
        	echo $form->field($model, 'selectmenu')            
		     ->dropDownList($left,
		     [
		      'multiple'=>'multiple',
		      'class'=>'form-control crossover-box',
		      'id'=> 'items',             
		     ]             
		    )->label("List Menu Tersedia"); 
        	?>
        </div>
        <div class="col-md-2" style="padding-top: 40px;">
            <button type="button" class="btn btn-primary crossover-btn" id="crossover-btn-add">Add</button>
            <button type="button" class="btn btn-primary crossover-btn" id="crossover-btn-remove">Remove</button>
        </div>
        <div class="col-md-5">
        	<?php 
        	echo $form->field($model, 'selectedmenu[]')            
		     ->dropDownList($right,
		     [
		      'multiple'=>'multiple',
		      'class'=>'form-control crossover-box',
		      'id'=> 'selected',             
		     ]             
		    )->label("Menu Yang Dipilih"); 
        	?>
        </div>
        <div></div>

    <div class="col-md-8 form-group" style="padding-top: 10px">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
    </div>
</div>
    <?php ActiveForm::end(); ?>

</div>
<script type="text/javascript">
	$( document ).ready(function() {
		crossover();
	});
	$('#bidang-fform').submit(function() {
		$('#items option').prop('selected', true);
		$('#selected option').prop('selected', true);
	});
</script>
