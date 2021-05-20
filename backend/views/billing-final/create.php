<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\BillingSementara */

$this->title = 'Create Billing';
$this->params['breadcrumbs'][] = ['label' => 'Billing Sementaras', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="billing-sementara-create">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
