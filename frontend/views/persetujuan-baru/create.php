<?php

use yii\helpers\Html;
use frontend\models\Peserta;

/* @var $this yii\web\View */
/* @var $model frontend\models\Persetujuan */
$nikes=$model->tpt_tp_nikes;
$data = 'SELECT td_nama_kel FROM tbl_daftar WHERE td_tp_nikes="'.$nikes.'" and flag_deleted=0 order by td_id LIMIT 1';
$result = Yii::$app->db->createCommand($data)->queryScalar();

// $nama = @Peserta::findOne($model->_id)->tp_nama_kel;
if (isset($_GET['uniq_code'])) {
	$this->title = 'Update Pemohonan Tindakan Pasien '.$result;
}else{
	$this->title = 'Pemohonan Tindakan Pasien '.$result;
}
$this->params['breadcrumbs'][] = ['label' => 'Persetujuans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="persetujuan-create">

    <!-- <h1><?= Html::encode($this->title) ?></h1> -->
    <?php
    		echo $this->render('_form', [
		        'model' => $model,
		    ]) ;
    ?>

</div>
