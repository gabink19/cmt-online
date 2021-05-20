<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use backend\models\Diagnosa;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\TopDiagnosa */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="top-diagnosa-form">

    <?php $form = ActiveForm::begin(); ?>    

    <!-- <div class="row"> -->
    <div class="col-md-8 col-xs-8">
    <?= $form->field($model, 'ttd_penamaan')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-8 col-xs-8">
    <?= $form->field($model, 'ttd_deskripsi')->textArea(['maxlength' => true]) ?>
    </div>
    <?php //echo  $form->field($model, 'ttd_tdg_kode')->widget(Select2::classname(), [
                    //     'options' => ['placeholder' => 'Select Brand CMP','readonly'=>true],
                    //     'hideSearch' => false,                        
                    //     'data' => ArrayHelper::map(Diagnosa::find()->all(),'tdg_kode','tdg_penamaan'),
                    //     'pluginOptions' => [
                    //         'multiple'=>true,
                    //         'maximumSelectionLength'=> 6,
                    //         'allowClear' => true
                    //     ],
                    // ]);
                    ?>
    <div class="col-md-8 col-xs-8">
        <div id="menu">
            <input id="cari" class="form-control" onkeyup="getnew();" placeholder="Filter here ...">
        </div>
        <div id="diagnosa-list">
        <?= $form->field($model, 'ttd_tdg_kode')->checkboxList($diagnosa)->label(false) ?>
        </div>
    </div>

    <div class="col-md-8 col-xs-8">
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>
    </div>
    <!-- </div> -->

    <?php ActiveForm::end(); ?>

</div>
<?php $urlLineCommand = $_SERVER["SCRIPT_NAME"].'?r=top-diagnosa/cari';?>
<style type="text/css">
    div#diagnosa-list {
  padding: 10px;
  background-color: white;
  border: 1px solid #d2d6de;
  margin: 0;
  overflow-y: scroll;
  height: 150px;
}
/* width */
::-webkit-scrollbar {
  width: 10px;
}

/* Track */
::-webkit-scrollbar-track {
  background: #f1f1f1;
}

/* Handle */
::-webkit-scrollbar-thumb {
  background: #888;
}

/* Handle on hover */
::-webkit-scrollbar-thumb:hover {
  background: #555;
}
div#menu{
  background-color: white;
  border: 1px solid #d2d6de;
  padding: 2px;
}
</style>
<script type="text/javascript">
    function getnew(){
        
        var kata = $("#cari").val();
        var url = '<?php echo $urlLineCommand; ?>&start='+kata;

        $.ajax({
          url: url,
          success: function(data) {
                $("#topdiagnosa-ttd_tdg_kode").html(data);            
          }
        });
    }
</script>