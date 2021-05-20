<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TopDiagnosa */

$this->title = 'Update Top Diagnosa: ' . $model->ttd_id;
$this->params['breadcrumbs'][] = ['label' => 'Top Diagnosas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->ttd_id, 'url' => ['view', 'id' => $model->ttd_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="top-diagnosa-update">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
