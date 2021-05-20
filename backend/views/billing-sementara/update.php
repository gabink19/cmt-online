<?php

use yii\helpers\Html;
use frontend\models\Pendaftaran;

/* @var $this yii\web\View */
/* @var $model frontend\models\BillingSementara */

$nama = @Pendaftaran::findOne($model->tbs_td_id)->td_nama_kel;
$this->title = "Permohonan Billing Sementara ".$nama;
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
