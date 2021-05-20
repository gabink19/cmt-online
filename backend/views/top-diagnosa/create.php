<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\TopDiagnosa */

$this->title = 'Create Top Diagnosa';
$this->params['breadcrumbs'][] = ['label' => 'Top Diagnosas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="top-diagnosa-create">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
        'diagnosa' => $diagnosa,
    ]) ?>

</div>
