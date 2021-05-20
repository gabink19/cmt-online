<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Peserta */

$this->title = 'Create Peserta';
$this->params['breadcrumbs'][] = ['label' => 'Peserta', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="peserta-create">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
