<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;
use yii\helpers\Url;
use backend\models\Peserta;

/* @var $this yii\web\View */
/* @var $model frontend\models\PesertaSearch */
/* @var $form yii\widgets\ActiveForm */

$session = Yii::$app->session;
$band = $session->get('band');

$session = Yii::$app->session;
$golongan = $session->get('golongan');

$urlnikes = Url::to(['pendaftaran/select']);
                            
?>

<div class="peserta-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="col-md-12 col-xs-12">
        <div class="col-md-6 col-xs-6">    

    <?= 
    $form->field($model, 'tp_nikes')->widget(Select2::classname(), [
                        // 'options' => ['placeholder' => 'Pilih Nikes'],
                        // 'hideSearch' => false,
                        // 'data' => ArrayHelper::map(Peserta::find()->all(),'tp_nikes','tp_nikes'),
                        'data' =>[],
                        'options' => ['placeholder' => 'Pilih Nikes'],
                        'hideSearch' => false,
                        'pluginOptions' => [
                            'allowClear' => true,
                            'minimumInputLength' => 3,
                            'language' => [
                                'errorLoading' => new JsExpression("function () { return 'Sedang mencari...'; }"),
                            ],
                            'ajax' => [
                                'url' => $urlnikes,
                                'dataType' => 'json',
                                'data' => new JsExpression('function(params) { return {q:params.term}; }')
                            ],
                            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                            'templateResult' => new JsExpression('function(city) { return city.text; }'),
                            'templateSelection' => new JsExpression('function (city) { return city.text; }'),
                        ],
                    ]);
   
    ?>

    <?= 
    $form->field($model, 'tp_band_posisi')->widget(Select2::classname(), [
                        'options' => ['placeholder' => 'Pilih Band Posisi'],
                        'hideSearch' => false,
                        'data' => ArrayHelper::map($band, 'tbp_id', 'tbp_penamaan'),
                        'pluginOptions' => [
                            'allowClear' => true
                        ]
                    ]);
   
    ?>

    <?= 
    $form->field($model, 'tp_gol')->widget(Select2::classname(), [
                        'options' => ['placeholder' => 'Pilih Gol'],
                        'hideSearch' => false,
                        'data' => ArrayHelper::map($golongan, 'tg_id', 'tg_penamaan'), 
                        'pluginOptions' => [
                            'allowClear' => true
                        ]
                    ]);
   
    ?>
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    
        </div>
    </div>

    <!-- <div class="col-md-12 col-xs-12"> -->
    <!-- </div> -->

    <?php ActiveForm::end(); ?>

</div>
