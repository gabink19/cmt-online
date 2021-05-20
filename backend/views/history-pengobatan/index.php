<?php

use frontend\models\Pendaftaran;
use frontend\models\BillingFinalSearch;
use frontend\models\PersetujuanSearch;
use yii\helpers\Html;
// use yii\grid\GridView;
use frontend\models\Peserta;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\PersetujuanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'History Pengobatan';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="persetujuan-index">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div id="background-hp1" style="margin-bottom: 10px; display: none;">
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    </div>
    
     <div class="col-md-1 col-xs-1">
        <?= Html::button('Search', ['class' => 'btn btn-success hp','id' => 'filter_button']);?>
    </div>

    <div class="col-md-11 col-xs-11">
        <?php $form = ActiveForm::begin([
            'action' => ['index'],
            'method' => 'get',
        ]); ?>
            <?= $form->field($searchModel, 'start_periode',['options' => ['style'=>'margin-top: -10px !important;margin-bottom: 0px !important']])->hiddenInput()->label(false) ?>
            <?= $form->field($searchModel, 'stop_periode',['options' => ['style'=>'margin-top: -10px !important;margin-bottom: 0px !important']])->hiddenInput()->label(false) ?>

            <?= Html::submitButton('View All', ['class' => 'btn btn-success']) ?>


        <?php ActiveForm::end(); ?>
    </div>

    <!-- <div class="col-md-2 col-xs-2"> -->
        <!-- // <?= Html::a('Create Persetujuan', ['create'], ['class' => 'btn btn-success']); ?> -->
    <!-- </div> -->

    <?= GridView::widget([
        'dataProvider' => $dataProvider,'responsiveWrap' => false,
        // 'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'kartik\grid\ExpandRowColumn',
                'expandAllTitle' => 'Expand all',
                'collapseTitle' => 'Collapse all',
                'enableRowClick' => false,
                'enableCache'=> false,
                'expandIcon'=>'<span class="glyphicon glyphicon-plus"></span>',
                'collapseIcon'=>'<span class="glyphicon glyphicon-minus"></span>',
                'value' => function ($model, $key, $index, $column) {
                        return GridView::ROW_COLLAPSED;
                },
                'detail' => function($model, $key, $index,$column){
                        $params = Yii::$app->request->queryParams;

                        $searchModel = new BillingFinalSearch();
                        $dataProvider = $searchModel->historysearchChild($params,$model['tp_nikes']);

                        // echo URL_GROUP_MDN_HIERARCHY;die();
                        return Yii::$app->controller->renderPartial('indextree', [
                            'searchModel1' => $searchModel,
                            'dataProvider1' => $dataProvider,
                        ]);
                }

            ],
            ['class' => 'yii\grid\SerialColumn'],

            // 'tpt_id',
           // 'tp_id',
            'tp_nikes',
            'tp_nik',
            // 'tp_nama_kk',
            // 'tp_status_kel',
            'tp_nama_kel',
            // 'tp_hr_pens',
            // 'tp_hr_host',
            // 'tp_band_posisi',
            'tp_tgl_lahir',
            'tp_umur',
            [
                'attribute' =>'tp_gol',
                'value' => function($data){
                    $session = Yii::$app->session;
                    $golongan = $session->get('golongan');
                    return @ArrayHelper::map($golongan, 'tg_id', 'tg_penamaan')[$data['tp_gol']];
                }, 
            ],
            
            [
                'attribute' =>'tp_nikes',
                'label'=>'Kategori Host',
                'value' => function($data){
                    $kategori_host = Peserta::find()->select(['kategori_host'])->where(['=','tp_nikes', $data['tp_nikes']])->one()->kategori_host;
                    return @Yii::$app->params["kategori_host"][$kategori_host];
                }, 
            ],
            // 'tp_tanggungan',
            // 'tp_tgl_pens',
            // 'tp_tgl_akhir_tanggunngan',
            // 'tp_jenis_peserta',
            [
                'attribute' =>'tp_jenis_kelamin',
                'value' => function($data){
                    return Yii::$app->params['jkelamin'][$data['tp_jenis_kelamin']];
                }, 
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                // 'header' => 'Actions',
                'template' => '<center>{save}</center>',
                'buttons' => [
                    'save' => function ($url, $model,$key) {
                        return Html::a('<span class="glyphicon glyphicon-download-alt" style="padding-right: 10px;"></span>', Url::to(['downloadpdf','nikes'=>$model['tp_nikes']]),[
                                    'title' => Yii::t('app', 'Save To PDF'),
                                    'target' => '_blank',
                        ]);
                    },
                  ],
            ],
            // ['class' => 'yii\grid\ActionColumn'],
            // [
            //     'class' => 'yii\grid\ActionColumn',
            //     // 'header' => 'Actions',
            //     'template' => '<center>{view}{update}{delete}</center>',
            //     'buttons' => [
            //         'view' => function ($url, $model,$key) {
            //             return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url."&uniq_code=".$model['tpt_uniq_code'], [
            //                         'title' => Yii::t('app', 'View'),
            //             ]);
            //         },
            //         'update' => function ($url, $model,$key) {
            //             return  Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
            //                         'title' => Yii::t('app', 'Update'),
            //             ]);
            //         },
            //         'delete' => function ($url, $model,$key) {
            //             return  Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
            //                         'title' => Yii::t('app', 'Delete'),'data-confirm'=>"Are you sure you want to delete this item?",'data-method'=>"post"
            //             ]);
            //         },
            //       ],
            // ],
        ],
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