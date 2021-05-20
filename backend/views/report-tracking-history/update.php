<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ReportTrackingHistory */

$this->title = 'Update Report Tracking History: ' . $model->tbs_id;
$this->params['breadcrumbs'][] = ['label' => 'Report Tracking Histories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->tbs_id, 'url' => ['view', 'id' => $model->tbs_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="report-tracking-history-update">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
