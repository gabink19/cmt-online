<?php

use yii\helpers\Html;
use frontend\models\Peserta;

/* @var $this yii\web\View */
/* @var $model frontend\models\Pendaftaran */
$nama = @Peserta::findOne($model->td_tp_id)->tp_nama_kel;
$this->title = 'Edit Data Pasien '.$nama;
$this->params['breadcrumbs'][] = ['label' => 'Pendaftarans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->td_id, 'url' => ['view', 'id' => $model->td_id]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="pendaftaran-update">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
