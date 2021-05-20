<?php

use yii\helpers\Html;
use kartik\grid\GridView;
// use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use frontend\models\Peserta;
use frontend\models\Pendaftaran;
use yii\widgets\ActiveForm;

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
            [
                'attribute' =>'tbs_td_id',
                'label'=>'Hak Kelas',
                'value' => function($data){
                    return @Pendaftaran::findOne($data['tbs_td_id'])->td_hak_kelas;
                }, 
            ],
            // [
            //     'attribute' =>'tbs_td_id',
            //     'label'=>'Jenis Peserta',
            //     'value' => function($data){
            //         $session = Yii::$app->session;
            //         $jenis_peserta = $session->get('jenis_peserta');
            //         return @ArrayHelper::map($jenis_peserta, 'tjp_id', 'tjp_penamaan')[@Pendaftaran::findOne($data['tbs_td_id'])->td_tp_jenis_peserta];
            //         // return @Pendaftaran::findOne($data['tbs_td_id'])->td_tp_jenis_peserta;
            //     }, 
            // ],
            
            [
                'attribute' =>'tbs_tp_nikes',
                'label'=>'Kategori Host',
                'value' => function($data){
                    $kategori_host = Peserta::find()->select(['kategori_host'])->where(['=','tp_nikes', $data['tbs_tp_nikes']])->one()->kategori_host;
                    return @Yii::$app->params["kategori_host"][$kategori_host];
                }, 
            ],
            // 'tbs_catatan_mitra',
            // 'tbs_path_billing',
            // 'tbs_flag_status',
            //'tbs_id_user_backend',
            // 'tbs_catatan_yakes',
            //'tbs_id_user_frontend',
            'tbs_nama_mitra',
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
                        if ($model['tbs_flag_status']!='') {
                            return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
                                        'title' => Yii::t('app', 'View'),
                            ]);
                        }
                    },
                    'update' => function ($url, $model,$key) {
                        if ($model['tbs_flag_status']=='') {
                            return Html::a('<span class="fufurez glyphicon glyphicon-check"></span>', $url, [
                                        'title' => Yii::t('app', 'Approve/Reject'),
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