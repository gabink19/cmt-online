<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use backend\Controllers\ReportApprovalController;
use backend\models\Diagnosa;
use yii\helpers\ArrayHelper;
use kartik\export\ExportMenu;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\PersetujuanTindakSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Report Proses Approval';
$this->params['breadcrumbs'][] = $this->title;
// echo "<pre>";
// echo phpinfo();
// echo "</pre>";
// die();
$columnExport=[
            ['class' => 'yii\grid\SerialColumn'],
            [
                'label'=>'NIKES',
                'attribute'=>'tpt_tp_nikes',//nama
                'value'=>function($model){
                    $nik = $model->tpt_tp_nikes;
                    return $nik;
                    
                }
            ],
            [
                'label'=>'Pasien',
                'attribute'=>'tpt_td_id',//nama
                'value'=>function($model){
                    return ReportApprovalController::getDaftar($model->tpt_td_id);
                    
                }
            ],
            [
                'attribute'=>'tpt_diagnosa',
                'value' => function($model){
                    return ArrayHelper::map(Diagnosa::find()->where(['tdg_id' => $model->tpt_diagnosa])->all(),'tdg_id','tdg_penamaan')[$model->tpt_diagnosa];
                }
            ],
            [
                'label'=>'Mitra',
                'attribute'=>'tpt_td_id',//mitra
                'value'=>function($model){
                    return ReportApprovalController::getDaftar($model->tpt_td_id,1);
                    
                }
            ],
            [
                'label'=>'Tujuan',
                'attribute'=>'tpt_td_id',//tujuan
                'value'=>function($model){
                    $data = ReportApprovalController::getDaftar($model->tpt_td_id,2);
                    return Yii::$app->params['tujuan'][$data];
                    
                }
            ],
            'tgl_permintaan',
            'tgl_persetujuan',
            [
                'label'=>'Approved By',
                'attribute'=>'last_user_backend',
            ],
            [
                'label'=>'Status',
                'attribute'=>'tpt_td_id',
                'value'=>function($model){
                    return Yii::$app->params['status_daftar'][ReportApprovalController::getDaftar($model->tpt_td_id,3)];
                    
                }
            ],
            [
                'label'=>'Lama Proses Approve',
                'attribute'=>'last_date_backend',
                'value'=>function($model){
                    return ReportApprovalController::getRentang($model->first_date_frontend,$model->last_date_backend);
                    
                },
            ],
        ];
?>
<div class="persetujuan-tindak-index">
    <?php// echo "zip: ", extension_loaded('zip') ? 'OK' : 'MISSING', '<br>'; echo phpinfo(); die();?>

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div id="background-hp1" style="margin-bottom: 10px; display: none;">
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    </div>
    
     <div class="col-md-10 col-xs-10">
        <?= Html::button('Filter', ['class' => 'btn btn-success hp','id' => 'filter_button']);?>
    </div>
    <!-- <div class="col-md-2 col-xs-2">
        <?= Html::a('Export Data', ['csv'], ['class' => 'btn btn-success','target'=>'_blank']); ?>
    </div> -->
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
                            'filename' =>"Report_Approval_".date("Y-m-d"),
                            'dropdownOptions' => [
                                'class' => 'btn btn-success'
                                ],
                            
            ]); 
            ?>
            </div>
    <br><br>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'responsiveWrap' => false,
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