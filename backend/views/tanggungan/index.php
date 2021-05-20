<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\TanggunganSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Tanggungans';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tanggungan-index">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
     <div id="background-hp1" style="margin-bottom: 10px; display: none;">
        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
    </div>
    
     <div class="col-md-10 col-xs-10">
        <?= Html::button('Search', ['class' => 'btn btn-success hp','id' => 'filter_button']);?>
    </div>

    <p>
        <?= Html::a('Create Tanggungan', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,'responsiveWrap' => false,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'tt_id',
            'tt_penamaan',
            'tt_keterangan',
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