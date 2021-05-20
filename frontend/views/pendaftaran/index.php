<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
use frontend\models\Peserta;

use yii\helpers\ArrayHelper;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $searchModel app\models\PendaftaranSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pendaftarans';
$this->params['breadcrumbs'][] = $this->title;
    $columns = [
            ['class' => 'yii\grid\SerialColumn'],

            // 'td_id',
            'td_tp_nikes',
            // 'td_tp_id',
            [
                'attribute' =>'td_tp_nama_kk',
                'value' => function($data){
                    return $data['td_tp_nama_kk'];
                }, 
            ],
            [
                'attribute' =>'td_nama_kel',
                'value' => function($data){
                    return $data['td_nama_kel'];
                }, 
            ],
            'td_tgl_daftar',
            // 'td_rekam_medis',
            // 'td_tujuan',
            [
                'attribute' =>'td_tujuan',
                'value' => function($data){
                    return @Yii::$app->params["tujuan"][$data['td_tujuan']];
                }, 
            ],
            [                
                'label'=>'Kategori Host',
                'value' => function($data){
                    $host = @Peserta::findOne($data['td_tp_id'])->tp_hr_host;
                    if ($host==69) {
                        $host = 'Pegawai';
                    }else{
                        $host = 'Pensiun';
                    }
                    return $host;
                }, 
            ],
            // 'td_tp_nik',
            'td_umur',
            // 'td_tp_nama_kk',
            // 'td_tp_no_bpjs',
            [
                'attribute' =>'td_tp_band_posisi',
                'value' => function($data){
                    $session = Yii::$app->session;
                    $band = $session->get('band');
                    return @ArrayHelper::map($band, 'tbp_id', 'tbp_penamaan')[$data['td_tp_band_posisi']];
                }, 
            ],
            // 'td_tp_jenis_peserta',
            // 'td_flag_status',
            'td_mitra',
            //'first_user',
            //'first_ip',
            //'last_user',
            //'last_ip',
            //'first_date',
            //'last_date',
            // 'td_path_rujukan',
            // 'td_hak_kelas',

            // ['class' => 'yii\grid\ActionColumn'],
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '<center>{view}{update}{delete}{downloadrujukandigital}</center>',
                'buttons' => [
                    'view' => function ($url, $model,$key) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open" style="padding-right: 10px;"></span>', $url, [
                                    'title' => Yii::t('app', 'View'),
                        ]);
                    },
                    'update' => function ($url, $model,$key) {
                        if ($model['td_tujuan']!=2) {
                            return '';
                        }
                        
                        if ($model['td_flag_status']>=5) {
                            return '';
                        }
                       
                        return Html::a('<span class="glyphicon glyphicon-pencil" style="padding-right: 10px;"></span>', $url, [
                                    'title' => Yii::t('app', 'Update'),
                        ]);
                    },
                    'delete' => function ($url, $model,$key) {
                        return  Html::a('<span class="glyphicon glyphicon-trash" style="padding-right: 10px;"></span>', $url, [
                                    'title' => Yii::t('app', 'Delete'),'data-confirm'=>"Are you sure you want to delete this item?",'data-method'=>"post"
                        ]);
                    },
                    'downloadrujukandigital' => function ($url, $model,$key) {
                        $que = 'select path_file from tbl_rujukan where tr_td_id="'.$model['td_id'].'" order by id desc limit 1';
                        $path = Yii::$app->db->createCommand($que)->queryScalar();
                        if ($path=='') {
                            return '';
                        }
                        // return $que;
                       
                        return Html::a('<span class="glyphicon glyphicon-download-alt" style="padding-right: 10px;"></span>', Url::to(['persetujuan/download','filename'=>$path]),[
                                    'title' => Yii::t('app', 'Download Rujukan'),
                        ]);
                    }
                  ],
            ],
        ];
?>
<div class="pendaftaran-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div id="background-hp1" style="margin-bottom: 10px; display: none;">
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    </div>
    
    <div class="col-md-1 col-xs-1">
        <?= Html::button('Search', ['class' => 'btn btn-success hp','id' => 'filter_button']);?>
    </div>

    <div class="col-md-9 col-xs-9">
        <?php $form = ActiveForm::begin([
            'action' => ['index'],
            'method' => 'get',
        ]); ?>
            <?= $form->field($searchModel, 'start_periode',['options' => ['style'=>'margin-top: -10px !important;margin-bottom: 0px !important']])->hiddenInput()->label(false) ?>
            <?= $form->field($searchModel, 'stop_periode',['options' => ['style'=>'margin-top: -10px !important;margin-bottom: 0px !important']])->hiddenInput()->label(false) ?>

            <?= Html::submitButton('View All', ['class' => 'btn btn-success']) ?>


        <?php ActiveForm::end(); ?>
    </div>

    <div class="col-md-2 col-xs-2">
        <?= Html::a('Create Pendaftaran', ['create'], ['class' => 'btn btn-success']); ?>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,'responsiveWrap' => false,
        // 'filterModel' => $searchModel,
        'columns' => $columns,
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