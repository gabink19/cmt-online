<?php

use frontend\models\Pendaftaran;
use frontend\models\PersetujuanSearch;
use yii\helpers\Html;
// use yii\grid\GridView;
use frontend\models\Peserta;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\PersetujuanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'History Persetujuans';
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

                        $searchModel = new PersetujuanSearch();
                        $q = 'SELECT tpt_uniq_code FROM tbl_persetujuan_tindak WHERE tpt_id='.$model['tpt_id'];
                        $uniq_code = Yii::$app->db->createCommand($q)->queryScalar();
                        $dataProvider = $searchModel->historysearchChild($params,$uniq_code,$model['tpt_id']);

                        if(isset($_GET['PersetujuanSearch'])){
                            $searchModel->start_periode = $_GET['PersetujuanSearch']['start_periode'];
                            $searchModel->stop_periode = $_GET['PersetujuanSearch']['stop_periode'];
                            $searchModel->tujuan = $_GET['PersetujuanSearch']['tujuan'];
                        }
                        // echo URL_GROUP_MDN_HIERARCHY;die();
                        return Yii::$app->controller->renderPartial('indextree', [
                            'searchModel1' => $searchModel,
                            'dataProvider1' => $dataProvider,
                        ]);
                }

            ],
            ['class' => 'yii\grid\SerialColumn'],

            // 'tpt_id',
            'tpt_tp_nikes',
            [
                'attribute' =>'tpt_td_id',
                'label'=>'Pegawai',
                'value' => function($data){
                    return @Pendaftaran::findOne($data['tpt_td_id'])->td_tp_nama_kk;
                }, 
            ],
            [
                'attribute' =>'tpt_td_id',
                'label'=>'Peserta',
                'value' => function($data){
                    return @Pendaftaran::findOne($data['tpt_td_id'])->td_nama_kel;
                }, 
            ],
            [
                'label' =>'Nomor Rekam Medis',
                'attribute' =>'tpt_td_id',
                'value' => function($data){
                    return @Pendaftaran::findOne($data['tpt_td_id'])->td_rekam_medis;
                }, 
            ],
            [
                'label' =>'Tujuan',
                'attribute' =>'tpt_td_id',
                'value' => function($data){
                    return @Yii::$app->params['tujuan'][Pendaftaran::findOne($data['tpt_td_id'])->td_tujuan];
                }, 
            ],
            [                
                'label'=>'Kategori Host',
                'value' => function($data){
                    $host = @Peserta::findOne(Pendaftaran::findOne($data['tpt_td_id'])->td_tp_id)->tp_hr_host;
                    if ($host==69) {
                        $host = 'Pegawai';
                    }else{
                        $host = 'Pensiun';
                    }
                    return $host;
                }, 
            ],
            'tpt_td_id',
            [
                'label'=>'Diagnosa',
                'attribute' =>'tpt_diagnosa',
                'value' => function($data){
                    $session = Yii::$app->session;
                    $band = $session->get('diagnosa');
                    return @ArrayHelper::map($band, 'tdg_id', 'tdg_penamaan')[$data['tpt_diagnosa']];
                }, 
            ],
            // 'tpt_catatan_mitra',
            // 'tpt_path_permintaan_tindak',
            //'tpt_flag_status',
            //'tpt_id_user_backend',
            //'tpt_catatan_yakes',
            //'tpt_id_user_frontend',
            //'tpt_nama_mitra',
            //'tpt_nama_user_backend',
            'tgl_permintaan',
            'tgl_persetujuan',
            
            [
                'attribute' =>'tpt_flag_status',
                'value' => function($data){
                    return ($data['tpt_flag_status']=='')?'Belum Di proses':@Yii::$app->params['persetujuan'][$data['tpt_flag_status']];
                }, 
            ],
            //'first_ip_backend',
            //'last_ip_backend',
            //'first_ip_frontend',
            //'last_ip_frontend',
            //'first_date_backend',
            //'last_date_backend',
            //'first_date_frontend',
            //'last_date_frontend',
            //'first_user_backend',
            //'last_user_backend',
            //'first_user_frontend',
            //'last_user_frontend',

            // ['class' => 'yii\grid\ActionColumn'],
            [
                'class' => 'yii\grid\ActionColumn',
                // 'header' => 'Actions',
                'template' => '<center>{view}{update}{delete}</center>',
                'buttons' => [
                    'view' => function ($url, $model,$key) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url."&uniq_code=".$model['tpt_uniq_code'], [
                                    'title' => Yii::t('app', 'View'),
                        ]);
                    },
                    'update' => function ($url, $model,$key) {
                        return  Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
                                    'title' => Yii::t('app', 'Update'),
                        ]);
                    },
                    'delete' => function ($url, $model,$key) {
                        return  Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
                                    'title' => Yii::t('app', 'Delete'),'data-confirm'=>"Are you sure you want to delete this item?",'data-method'=>"post"
                        ]);
                    },
                  ],
            ],
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