<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ImportBatchSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Import Batch';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="import-batch-index">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div id="background-hp1" style="margin-bottom: 10px; display: none;">
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    </div>
    <div class="col-md-10 col-xs-10">
        <?= Html::button('Search', ['class' => 'btn btn-success hp','id' => 'filter_button']);?>
    </div>

    <div class="col-md-2 col-xs-2">
        <?= Html::a('Import Batch .csv', ['#'], ['class' => 'btn btn-success','onclick'=>'openmodalUpload(); return false;']); ?>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'responsiveWrap' => false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'tib_date',
            'tib_filename',
            // 'tib_status',
            [
                'attribute' => 'tib_status',
                 'value' => function ($data){
                    $params = Yii::$app->params['statusImport'];
                    $type = @$data['tib_status'];
                    return @$params[$type];
                },
            ],
            'tib_total',
            'tib_success',
            'tib_failed',
            'first_user',
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Actions',
                'template' => '<center>{download}  {log}</center>',
                'buttons' => [
                    'download' => function ($url, $model,$key) {
                        if ($model['tib_status']==2) {
                            return Html::a('<span class="fa fa-download"></span>', ['persetujuan/download','filename'=>Yii::$app->params['pathImportfinish'].$model['tib_filename']],['class' => 'btn btn-success','style'=>'margin-top: 3px;','title' => 'Download File']);
                        }
                    },
                    'log' => function ($url, $model,$key) {
                        if ($model['tib_failed']>0) {
                            $filename = str_replace('.csv', '.txt', $model['tib_filename']);
                            return Html::a('<span class="fa fa-archive"></span>', ['persetujuan/download','filename'=>Yii::$app->params['pathImportresult'].$filename], ['class' => 'btn btn-success','style'=>'margin-top: 3px;','title' => 'Download Log Failed']);
                        }
                    },
                  ],
            ],
        ],
    ]); ?>
</div>
<?php
    Modal::begin([
        'header' => '<h4>Import .csv</h4>',
        'id' => 'insert-batch-form',
        'size' => 'modal-lg',        
    ]);
    echo "{$this->render('upload', ['model' => $model])}";
    Modal::end();
?>
<script type="text/javascript">
    function openmodalUpload() {
        $('.modal-dialog').width(640);
        $('#insert-batch-form').modal('show');
    }
</script>