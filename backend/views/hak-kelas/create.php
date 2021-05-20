<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\HakKelas */

$this->title = 'Create Hak Kelas';
$this->params['breadcrumbs'][] = ['label' => 'Hak Kelas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="hak-kelas-create">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
