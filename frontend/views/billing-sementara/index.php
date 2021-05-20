<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
use frontend\models\Peserta;
use frontend\models\Pendaftaran;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\BillingSementaraSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Billing';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="billing-sementara-index">

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
        <!-- <?= Html::a('Create Billing', ['create'], ['class' => 'btn btn-success']); ?> -->
    <!-- </div> -->

    <?= GridView::widget([
        'dataProvider' => $dataProvider,'responsiveWrap' => false,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'tbs_id',
            'tbs_tp_nikes',
            'tbs_td_id',
            [
                'attribute' =>'tbs_td_id',
                'label'=>'Pegawai',
                'value' => function($data){
                    return @Pendaftaran::findOne($data['tbs_td_id'])->td_tp_nama_kk;
                }, 
            ],
            [
                'attribute' =>'tbs_td_id',
                'label'=>'Peserta',
                'value' => function($data){
                    return @Pendaftaran::findOne($data['tbs_td_id'])->td_nama_kel;
                }, 
            ],
            // 'tbs_catatan_mitra',
            // 'tbs_path_billing',
            // 'tbs_flag_status',
            //'tbs_id_user_backend',
            // 'tbs_catatan_yakes',
            //'tbs_id_user_frontend',
            'tbs_nama_mitra',
            [                
                'label'=>'Kategori Host',
                'value' => function($data){
                    $host = @Peserta::findOne(Pendaftaran::findOne($data['tbs_td_id'])->td_tp_id)->tp_hr_host;
                    if ($host==69) {
                        $host = 'Pegawai';
                    }else{
                        $host = 'Pensiun';
                    }
                    return $host;
                }, 
            ],
            //'tbs_nama_user_backend',
            'tgl_billing',
            'tgl_billing_diresponse',
            [
                'label' =>'Status',
                // 'attributes' =>'tbs_flag_status',
                'value' => function($data){
                    return @Yii::$app->params['persetujuanBilling'][$data['tbs_flag_status']];
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
            //'flag_deleted',

            [
                'class' => 'kartik\grid\ActionColumn',
                // 'header' => 'Actions',
                'template' => '<center>{view}{update}</center>',
                'buttons' => [
                    'view' => function ($url, $model,$key) {
                        // if ($model['tbs_flag_status']!='') {
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                        'title' => Yii::t('app', 'View'),
                            ]);
                        // }
                    },
                    'update' => function ($url, $model,$key) {
                        if ($model['tbs_flag_status']=='') {
                            return Html::a('<span class="fufurez glyphicon glyphicon-pencil"></span>', $url, [
                                        'title' => Yii::t('app', 'Update'),
                            ]);
                        }
                    },
                  ],
            ],
        ],
    ]); ?>
</div>
<script type="text/javascript">
    $( document ).ready(function() {
        setTimeout(function(){ location.reload(); }, 60000);
    }); 
</script>
<?php
$url = $_SERVER["SCRIPT_NAME"].'?r='.$this->context->id;

$js = <<<JS
$("#filter_button").on("click",function(){
        $("#background-hp1").toggle('normal');
    });  
JS;
$this->registerJs($js);
?>
