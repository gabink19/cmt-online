<?php

use frontend\models\Pendaftaran;
use yii\helpers\Html;
use yii\helpers\Url;
// use yii\grid\GridView;
use frontend\models\Peserta;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\PersetujuanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

// $this->title = 'History Persetujuan';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="persetujuan-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider1,
        'responsiveWrap' => false,
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
            [
                'class' => 'yii\grid\ActionColumn',
                // 'header' => 'Actions',
                'template' => '<center>{view}</center>',
                'buttons' => [
                    'view' => function ($url, $model,$key) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', Url::to(['billing-final/view','id'=>$model['tbs_id']]), [
                                    'title' => Yii::t('app', 'View'),
                                    'target' => '_blank',
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