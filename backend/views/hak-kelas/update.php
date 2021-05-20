<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\HakKelas */

$this->title = 'Edit Hak Kelas: ' . $model->thk_id;
$this->params['breadcrumbs'][] = ['label' => 'Hak Kelas', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->thk_id, 'url' => ['view', 'id' => $model->thk_id]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="hak-kelas-update">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
