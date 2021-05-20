<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\PersetujuanTindak */

$this->title = 'Create Persetujuan Tindak';
$this->params['breadcrumbs'][] = ['label' => 'Persetujuan Tindaks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="persetujuan-tindak-create">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
