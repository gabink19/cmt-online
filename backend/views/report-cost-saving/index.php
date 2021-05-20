<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use kartik\grid\GridView;
use backend\models\Diagnosa;
use backend\Controllers\ReportCostSavingController;
use yii\helpers\ArrayHelper;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\PersetujuanTindakSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Report Cost Saving';
$this->params['breadcrumbs'][] = $this->title;
$columnExport=[
            ['class' => 'yii\grid\SerialColumn'],
            'tpt_tp_nikes',
            [
                'label'=>'Pasien',
                'attribute'=>'tpt_td_id',//nama
                'value'=>function($model){
                    return ReportCostSavingController::getDaftar($model->tpt_td_id);
                    
                }
            ],
            [
                'label'=>'Kategori Host',
                'attribute'=>'tpt_td_id',//nama
                'value'=>function($model){
                    $data = ReportCostSavingController::getDaftar($model->tpt_td_id,5);
                    return Yii::$app->params['kat_host'][$data];
                }
            ],
            [
                'attribute'=>'tpt_diagnosa',
                'value' => function($model){
                    return ArrayHelper::map(Diagnosa::find()->where(['tdg_id' => $model->tpt_diagnosa])->all(),'tdg_id','tdg_penamaan')[$model->tpt_diagnosa];
                }
            ],
            [
                'label'=>'Tujuan',
                'attribute'=>'tpt_td_id',//tujuan
                'value'=>function($model){
                    $data = ReportCostSavingController::getDaftar($model->tpt_td_id,4);
                    return Yii::$app->params['tujuan'][$data];
                    
                }
            ],
            [
                'label'=>'Mitra',
                'attribute'=>'tpt_td_id',//mitra
                'value'=>function($model){
                    return ReportCostSavingController::getDaftar($model->tpt_td_id,1);
                }
            ],
            'tgl_permintaan',
            'tgl_persetujuan',
            [
                'attribute'=>'biaya',//mitra
                'value'=>function($model){
                    $hasil_rupiah = "Rp " . number_format($model->biaya,0,',','.');
                    return $hasil_rupiah;
                }
            ],
            [
                'attribute'=>'biaya_disetujui',//mitra
                'value'=>function($model){
                    $hasil_rupiah = "Rp " . number_format($model->biaya_disetujui,0,',','.');
                    return $hasil_rupiah;
                }
            ],
            [
                'label'=>'Status',
                'attribute'=>'tpt_td_id',
                'value'=>function($model){
                    return Yii::$app->params['status_daftar'][ReportCostSavingController::getDaftar($model->tpt_td_id,3)];
                    
                }
            ],
            [
                'label'=>'Cost Saving',
                'attribute'=>'tpt_td_id',
                'value'=>function($model){
                    $hasil = $model->biaya_disetujui - $model->biaya;
                    if($hasil < 0){
                        $hasil = null;
                    }
                    $hasil_rupiah = "Rp " . number_format($hasil,0,',','.');
                    return $hasil_rupiah;
                    
                }
            ],
        ];
?>
<div class="persetujuan-tindak-index">

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
                            'filename' =>"Report_Cost_Saving".date("Y-m-d"),
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