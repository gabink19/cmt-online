<?php

use yii\helpers\Html;
use frontend\models\Pendaftaran;

/* @var $this yii\web\View */
/* @var $model frontend\models\Persetujuan */


$nama = @Pendaftaran::findOne($model->tpt_td_id)->td_nama_kel;

$this->title = "Edit Data Pasien ".$nama;
$this->params['breadcrumbs'][] = ['label' => 'Persetujuans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->tpt_id, 'url' => ['view', 'id' => $model->tpt_id]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="persetujuan-update">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
