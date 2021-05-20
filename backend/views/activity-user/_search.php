<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\ActivityUserSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="activity-user-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'username') ?>

    <?= $form->field($model, 'berita') ?>

    <?= $form->field($model, 'ip') ?>

    <?= $form->field($model, 'start_periode')->widget(DatePicker::classname(), [
            'options' => ['placeholder' => 'Start Date'],
            'pluginOptions' => [
                'autoclose'=>true,
                'format' => 'yyyy-m-d',
            ]
        ]);
    ?>

    
    <?= $form->field($model, 'stop_periode')->widget(DatePicker::classname(), [
                'options' => ['placeholder' => 'Stop Date'],
                'pluginOptions' => [
                    'autoclose'=>true,
                    'format' => 'yyyy-m-d',
                ]
            ]);
        ?>




    
            <div class="form-group">
                <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
            </div>

    <?php ActiveForm::end(); ?>

</div>
