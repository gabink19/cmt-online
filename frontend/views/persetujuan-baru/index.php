<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use kartik\grid\GridView;
use yii\widgets\ActiveForm;
use frontend\models\Peserta;

use yii\helpers\Url;
use yii\helpers\ArrayHelper;
/* @var $this yii\web\View */
/* @var $searchModel app\models\PendaftaranSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Daftar Pasien';
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
                'class' => 'yii\grid\ActionColumn',
                // 'header' => 'Actions',
                'template' => '<center>{view}{update}{lanjutkan}</center>',
                'buttons' => [
                    'view' => function ($url, $model,$key) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open" style="padding-right: 10px;"></span>', $url, [
                                    'title' => Yii::t('app', 'View'),
                        ]);
                    },
                    'update' => function ($url, $model,$key) {
                        $q = 'SELECT tpt_flag_status,tpt_uniq_code FROM tbl_persetujuan_tindak WHERE tpt_td_id="'.$model['td_id'].'" order by tpt_id desc limit 1';
                        $data = Yii::$app->db->createCommand($q)->queryOne();
                        if (($data['tpt_uniq_code']!='' && $data['tpt_flag_status']=='')||($data['tpt_uniq_code']!='' && $data['tpt_flag_status']=='1')) {
                            return '';
                        }
                        if ($model['td_flag_status']>=5) {
                            return '';
                        }
                        $data = 'SELECT count(*) FROM tbl_billing_final WHERE tbs_td_id="'.$model['td_id'].'" order by tbs_id LIMIT 1';
                        $avail = Yii::$app->db->createCommand($data)->queryScalar();
                        // return $data;
                        return ($avail>0)?'':Html::a('<span class="glyphicon glyphicon-edit"  style="padding-right: 10px;"></span>', Url::to(['persetujuan-baru/create']).'&id='.$model['td_id'].'&nikes='.$model['td_tp_nikes'], [
                                    'title' => Yii::t('app', 'Ajukan Persetujuan Tindak'),
                        ]);
                    },
                    'lanjutkan' => function ($url, $model,$key) {
                        if ($model['td_flag_status']>=5) {
                            return '';
                        }
                        $q = 'SELECT tpt_flag_status,tpt_uniq_code FROM tbl_persetujuan_tindak WHERE tpt_td_id="'.$model['td_id'].'" order by tpt_id desc limit 1';
                        $data = Yii::$app->db->createCommand($q)->queryOne();
                        if ($data['tpt_flag_status']==1) {
                            return Html::a('<span class="glyphicon glyphicon-indent-left"></span>', Url::to(['persetujuan-baru/create']).'&id='.$model['td_id'].'&nikes='.$model['td_tp_nikes'].'&uniq_code='.$data['tpt_uniq_code'], [
                                    'title' => Yii::t('app', 'Lanjutkan Persetujuan Tindak'),
                            ]);
                        }else{
                            return '';
                        }
                        // return $data;
                        // return ($avail==0)?'':
                    },
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
        'columns' => $columns,
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