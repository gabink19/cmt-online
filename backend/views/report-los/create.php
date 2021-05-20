<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ReportLos */

$this->title = 'Create Report Los';
$this->params['breadcrumbs'][] = ['label' => 'Report Los', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-los-create">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
