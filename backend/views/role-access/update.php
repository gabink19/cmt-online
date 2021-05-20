<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\RoleAccess */

$this->title = 'Edit Role Access: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Role Accesses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Edit';
?>
<div class="role-access-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
