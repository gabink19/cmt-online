<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ReportLos */

$this->title = 'Update Report Los: ' . $model->tbs_id;
$this->params['breadcrumbs'][] = ['label' => 'Report Los', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->tbs_id, 'url' => ['view', 'id' => $model->tbs_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="report-los-update">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
