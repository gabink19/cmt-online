<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\BillingSementara */
// echo "<pre>";
// print_r($model);
// echo "</pre>";
// die();
$nikes=$model->tbs_tp_nikes;
$data = 'SELECT td_nama_kel FROM tbl_daftar WHERE td_tp_nikes="'.$nikes.'" and flag_deleted=0 order by td_id LIMIT 1';
$result = Yii::$app->db->createCommand($data)->queryScalar();

$this->title = 'Permohonan Billing Sementara: ' . $result;
$this->params['breadcrumbs'][] = ['label' => 'Billing Sementaras', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->tbs_id, 'url' => ['view', 'id' => $model->tbs_id]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="billing-sementara-update">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
