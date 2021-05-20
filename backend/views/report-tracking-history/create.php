<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ReportTrackingHistory */

$this->title = 'Create Report Tracking History';
$this->params['breadcrumbs'][] = ['label' => 'Report Tracking Histories', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-tracking-history-create">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
