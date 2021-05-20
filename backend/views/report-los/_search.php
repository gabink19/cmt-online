<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model backend\models\ReportLosSearch */
/* @var $form yii\widgets\ActiveForm */
$query = 'SELECT tdg_id as id, tdg_penamaan as nama, tdg_kode as kode FROM tbl_diagnosa LIMIT 30';
$command = Yii::$app->db->createCommand($query);
$data = $command->queryAll();
foreach ($data as $key => $value) {
    $newarray[$value['id']] = $value['kode'] ." - ".$value['nama'];
}
?>

<div class="report-los-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="col-md-12 col-xs-12">
        <div class="col-md-6 col-xs-6"> 
    <?= $form->field($model, 'priode')->dropDownList(Yii::$app->params['tipe_bulan'], ['prompt'=>'All']); ?>

    <div id="perbulan" style="display: none;">
    <?= $form->field($model, 'start_periode')->widget(DatePicker::classname(), [
                        'options' => ['placeholder' => 'Start Date'],
                        'pluginOptions' => [
                            'autoclose'=>true,
                            'format' => 'yyyy-mm',
                            'startView'=>'month',
                            'minViewMode'=>'months'
                        ]
                    ]); ?>

    <?= $form->field($model, 'stop_periode')->widget(DatePicker::classname(), [
                        'options' => ['placeholder' => 'Start Date'],
                        'pluginOptions' => [
                            'autoclose'=>true,
                            'format' => 'yyyy-mm',
                            'startView'=>'month',
                            'minViewMode'=>'months'
                        ]
                    ]); ?>
    </div>
    <div id="triwulan" style="display: none;">
    <?= $form->field($model, 'tahuntri')->widget(DatePicker::classname(), [
                        'options' => ['placeholder' => 'Tahun Triwulan'],
                        'pluginOptions' => [
                            'autoclose'=>true,
                            'format' => 'yyyy',
                            'startView'=>'year',
                            'minViewMode'=>'years'
                        ]
                    ]); ?>

    <?= $form->field($model, 'triwulan')->dropDownList(Yii::$app->params['triwulanhp']); ?>
    </div>
    <div id="pertahun" style="display: none;">
        <?= $form->field($model, 'start_periode2')->widget(DatePicker::classname(), [
                        'options' => ['placeholder' => 'Start Date'],
                        'pluginOptions' => [
                            'autoclose'=>true,
                            'format' => 'yyyy',
                            'startView'=>'year',
                            'minViewMode'=>'years'
                        ]
                    ]); ?>

    <?= $form->field($model, 'stop_periode2')->widget(DatePicker::classname(), [
                        'options' => ['placeholder' => 'Start Date'],
                        'pluginOptions' => [
                            'autoclose'=>true,
                            'format' => 'yyyy',
                            'startView'=>'year',
                            'minViewMode'=>'years'
                        ]
                    ]); ?>
    </div>

    <?= $form->field($model, 'tbs_diagnosa')->widget(Select2::classname(), [
                        'options' => ['placeholder' => 'Pilih Diagnosa'],
                        'hideSearch' => false,
                        // 'data' => ArrayHelper::map(Diagnosa::find()->all(),'tdg_id','tdg_penamaan'),
                        'data' => $newarray,
                        'pluginOptions' => [
                            'allowClear' => true
                        ]
                    ]);
   
    ?>

    <?= $form->field($model, 'status')->dropDownList(Yii::$app->params['status_daftarD'], ['prompt'=>'All']); ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

       </div>
    </div>
</div>
<?php
$js = <<<JS

$(document).ready(function () {
        var val = $('#reportlossearch-priode').val();
        if(val == '1' ) {
          $('#perbulan').show('normal');
        }
        if(val == '2' ) {
          $('#triwulan').show('normal');
        } 
        if(val == '3' ) {
          $('#pertahun').show('normal');
        } 
});

$(document).ready(function () {
    $(document.body).on('change', '#reportlossearch-priode', function () {
        var val = $('#reportlossearch-priode').val();
        if(val == '1' ) {
          $('#pertahun').hide('normal');
          $('#triwulan').hide('normal');
          $('#perbulan').show('normal');
        }
        if(val == '2' ) {
          $('#pertahun').hide('normal');
          $('#perbulan').hide('normal');
          $('#triwulan').show('normal');
        } 
        if(val == '3' ) {
          $('#perbulan').hide('normal');
          $('#triwulan').hide('normal');
          $('#pertahun').show('normal');
        } 
    });
});

JS;
$this->registerJs($js);

?>