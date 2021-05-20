<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;

use frontend\models\Peserta;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\PesertaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pesertas';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="peserta-index">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div id="background-hp1" style="margin-bottom: 10px; display: none;">
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    </div>
    
     <div class="col-md-10 col-xs-10">
        <?= Html::button('Search', ['class' => 'btn btn-success hp','id' => 'filter_button']);?>
    </div>

    <div class="col-md-2 col-xs-2">
        <?= Html::a('Create Peserta', ['create'], ['class' => 'btn btn-success']); ?>
    </div>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,'responsiveWrap' => false,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

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
            // 'tp_no_bpjs',
            // 'tp_flag_active',

            ['class' => 'kartik\grid\ActionColumn'],
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