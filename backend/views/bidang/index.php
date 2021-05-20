<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\BidangSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Bidangs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bidang-index">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->
    <?php //echo $this->render('_search', ['model' => $searchModel]); ?>


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

            'tb_id',
            'tb_nama_bidang',
            'tb_keterangan',
            // 'tb_flag_akses',
            [
                'attribute' =>'tb_flag_akses',
                'value' => function($data){
                    return Yii::$app->params['typeUser'][$data['tb_flag_akses']];
                }, 
            ],
            // 'flag_deleted',

            ['class' => 'yii\grid\ActionColumn'],
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
