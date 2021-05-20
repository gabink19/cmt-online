<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\PersetujuanTindak */

$this->title = 'Update Persetujuan Tindak: ' . $model->tpt_id;
$this->params['breadcrumbs'][] = ['label' => 'Persetujuan Tindaks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->tpt_id, 'url' => ['view', 'id' => $model->tpt_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="persetujuan-tindak-update">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
