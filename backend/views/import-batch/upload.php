<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
// use kartik\widget\ActiveForm; // or yii\widgets\ActiveForm
use kartik\file\FileInput;

/* @var $this yii\web\View */
/* @var $model app\models\GroupMdnDetail */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="list-mdn-form">
	<?php 
		$form = ActiveForm::begin([
			'options' => ['enctype' => 'multipart/form-data'],
			'action' => ['upload'],
		]) ?>

	<?php
	 echo $form->field($model, 'tib_filename')->widget(FileInput::classname(), [
              // 'options' => ['accept' => 'doc/*'],
               'pluginOptions' => [
               		'width'=> '90%',
               		'allowedFileExtensions'=>['csv'],
			        'showPreview' => false,
			        'showCaption' => true,
			        'showRemove' => true,
			        'showCancel' => false,
			        'showUpload' => false,
			    ]
          ]);   
          ?>
	<!-- <div class="help-block" style="width: 100%">Format : mdn|name|type|group|customer, Ex : 6288147771877|Miracle|Postpaid|Divisi|Perusahaan</div> -->

	<div class="form-group">
		<?= Html::submitButton('Upload', ['class' => 'btn btn-success']) ?>
	</div>

	<?php ActiveForm::end() ?>

</div>
