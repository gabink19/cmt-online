<?php

use yii\helpers\Html;
use yii\grid\GridView;
// use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

use frontend\models\Peserta;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\PesertaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Data Peserta';
$this->params['breadcrumbs'][] = $this->title;
ini_set('memory_limit', '4095M');
ini_set('max_execution_time', 300);
?>
<div class="peserta-index">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <style type="text/css">
        table { 
        border-collapse: collapse !important;
        }

    /* Zebra striping */
    tr:nth-of-type(odd) { 
        background: #eee !important; 
        }

    th { 
        background: #e5131d !important; 
        color: white !important; 
        font-weight: bold !important; 
        }
    a {
        color: white !important; 
        cursor: default !important;
        text-decoration: none !important;
    }
    td, th { 
        padding: 10px !important; 
        border: 1px solid #ccc !important; 
        text-align: left !important; 
        font-size: 18px !important;
        }
    </style>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'responsiveWrap' => false,
        'layout' => '{items}',
        // 'filterModel' => $searchModel,

        // 'responsive'=>true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'tp_id',
            [
                'label'=>'Nikes',
                'value' => function($data){                    
                    return $data['tp_nikes'];
                }, 
            ],
            [
                'label'=>'NIK',
                'value' => function($data){                    
                    return $data['tp_nik'];
                }, 
            ],
            // 'tp_nama_kk',
            // 'tp_status_kel',
            [
                'label'=>'Nama Keluarga',
                'value' => function($data){                    
                    return $data['tp_nama_kel'];
                }, 
            ],
            // 'tp_hr_pens',
            // 'tp_hr_host',
            // 'tp_band_posisi',
            [
                'label'=>'Tgl Lahir',
                'value' => function($data){                    
                    return $data['tp_tgl_lahir'];
                }, 
            ],
            [
                'label'=>'Umur',
                'value' => function($data){                    
                    return $data['tp_umur'];
                }, 
            ],
            [
                'label'=>'Golongan',
                'value' => function($data){
                    $session = Yii::$app->session;
                    $golongan = $session->get('golongan');
                    return @ArrayHelper::map($golongan, 'tg_id', 'tg_penamaan')[$data['tp_gol']];
                }, 
            ],
            
            [
                // 'attribute' =>'tp_nikes',
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
                'label'=>'Jenis Kelamin',
                'value' => function($data){
                    return Yii::$app->params['jkelamin'][$data['tp_jenis_kelamin']];
                }, 
            ],
            // 'tp_no_bpjs',
            // 'tp_flag_active',

            // ['class' => 'kartik\grid\ActionColumn'],
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