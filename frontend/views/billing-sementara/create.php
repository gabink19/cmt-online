<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\BillingSementara */

$nikes=$model->tbs_tp_nikes;
$data = 'SELECT td_nama_kel FROM tbl_daftar WHERE td_tp_nikes="'.$nikes.'" and flag_deleted=0 order by td_id LIMIT 1';
$result = Yii::$app->db->createCommand($data)->queryScalar();

$this->title = 'Edit Data Pasien '.$result;
$this->params['breadcrumbs'][] = ['label' => 'Billing Sementaras', 'url' => ['index']];
$this->params['breadcrumbs'][] = $result;
?>
<div class="billing-sementara-create">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
