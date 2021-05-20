<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use backend\Controllers\ReportLosController;
use yii\helpers\ArrayHelper;
use kartik\export\ExportMenu;
use backend\models\Diagnosa;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ReportLosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Report Length of Stay ';
$this->params['breadcrumbs'][] = $this->title;
$columnExport=[
            ['class' => 'yii\grid\SerialColumn'],

            // 'tbs_id',
            'tbs_tp_nikes',
            [
                'label'=>'Pasien',
                'attribute'=>'tbs_td_id',//nama
                'value'=>function($model){
                    return ReportLosController::getDaftar($model->tbs_td_id);
                    
                }
            ],
            [
                'label'=>'Umur',
                'attribute'=>'tbs_td_id',//nama
                'value'=>function($model){
                    return ReportLosController::getDaftar($model->tbs_td_id,2);
                    
                }
            ],
            [
                'label'=>'Kategori Host',
                'attribute'=>'tbs_td_id',//nama
                'value'=>function($model){
                    $data = ReportLosController::getDaftar($model->tbs_td_id,3);
                    return Yii::$app->params['kat_host'][$data];
                    
                }
            ],
            [
                'attribute'=>'tbs_diagnosa',
                'value' => function($model){
                    return ArrayHelper::map(Diagnosa::find()->where(['tdg_id' => $model->tbs_diagnosa])->all(),'tdg_id','tdg_penamaan')[$model->tbs_diagnosa];
                }
            ],
            [
                'label'=>'Tujuan',
                'attribute'=>'tbs_td_id',//tujuan
                'value'=>function($model){
                    $data = ReportLosController::getDaftar($model->tbs_td_id,4);
                    return Yii::$app->params['tujuan'][$data];
                    
                }
            ],
            [
                'label'=>'Mitra',
                'attribute'=>'tbs_td_id',//mitra
                'value'=>function($model){
                    return ReportLosController::getDaftar($model->tbs_td_id,1);
                    
                }
            ],
            // [
            //     'label'=>'Priode Bulan',
            //     'attribute'=>'tbs_td_id',//nama
            //     'value'=>function($model){
            //         // return ReportLosController::getDaftar($model->tbs_td_id);
                    
            //     }
            // ],
            'tgl_billing',
            'tgl_billing_diresponse',
            [
                'attribute'=>'tbs_biaya',//mitra
                'value'=>function($model){
                    $hasil_rupiah = "Rp " . number_format($model->tbs_biaya,0,',','.');
                    return $hasil_rupiah;
                    
                }
            ],
            [
                'label'=>'LOS',
                'attribute'=>'last_date_backend',
                'value'=>function($model){
                    return ReportLosController::getRentang($model->tgl_billing,$model->tgl_billing_diresponse);
                    
                },
            ],
            [
                'label'=>'Status',
                'attribute'=>'tbs_td_id',
                'value'=>function($model){
                    return Yii::$app->params['status_daftar'][ReportLosController::getDaftar($model->tbs_td_id,5)];
                    
                }
            ],
        ];
?>
<div class="report-los-index">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div id="background-hp1" style="margin-bottom: 10px; display: none;">
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    </div>
    
     <div class="col-md-10 col-xs-10">
        <?= Html::button('Filter', ['class' => 'btn btn-success hp','id' => 'filter_button']);?>
    </div>
    <div class="col-md-2 col-xs-2">
            <?php 
            echo ExportMenu::widget([
                            'dataProvider' => $dataProvider,
                            'columns' => $columnExport,
                            'showConfirmAlert' => false,
                            'showColumnSelector' => false,
                            'target' => ExportMenu::TARGET_SELF,
                            'exportConfig' => [
                                ExportMenu::FORMAT_HTML => false,
                                ExportMenu::FORMAT_EXCEL => [
                                        'label' => 'Export Excel'
                                ],
                                // ExportMenu::FORMAT_EXCEL_X => [
                                //         'label' => 'Export Excel 2'
                                // ],
                                ExportMenu::FORMAT_EXCEL_X => false,
                                ExportMenu::FORMAT_PDF => false,
                                ExportMenu::FORMAT_TEXT => false,
                                ExportMenu::FORMAT_CSV =>  false
                            ],
                            'filename' =>"Report_Case_Monitoring".date("Y-m-d"),
                            'dropdownOptions' => [
                                'class' => 'btn btn-success'
                                ],
                            
            ]); 
            ?>
            </div>
    <br><br>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => $columnExport,
    ]); ?>
</div>
<?php
$url = $_SERVER["SCRIPT_NAME"].'?r='.$this->context->id;

$js = <<<JS
$("#filter_button").on("click",function(){
        $("#background-hp1").toggle('normal');
    });  
JS;
$this->registerJs($js);
?>