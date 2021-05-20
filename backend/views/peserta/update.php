<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Peserta */

$this->title = 'Edit Peserta: ' . $model->tp_nik;
$this->params['breadcrumbs'][] = ['label' => 'Pesertas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->tp_id, 'url' => ['view', 'tp_id' => $model->tp_id, 'tp_nikes' => $model->tp_nikes]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="peserta-update">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
