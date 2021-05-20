<?php 
use frontend\models\Pendaftaran;
use frontend\models\Diagnosa;
use yii\helpers\ArrayHelper;

$session = Yii::$app->session;
$diagnosa = $session->get('diagnosa');


if (strpos($model->biaya, '.')==true) {
  $model->biaya = str_replace('.', '', $model->biaya);
}
$model->biaya = number_format($model->biaya,0,",",".");


if (strpos($model->biaya_disetujui, '.')==true) {
  $model->biaya_disetujui = str_replace('.', '', $model->biaya_disetujui);
}
$model->biaya_disetujui = number_format($model->biaya_disetujui,0,",",".");
?>
<style type="text/css">
th {
    background: #e5131d;
    color: white;
}
h3 {
  text-align: center;
}

table caption {
  padding: .5em 0;
}

@media screen and (max-width: 767px) {
  table caption {
    border-bottom: 1px solid #ddd;
  }
}

.p {
  text-align: center;
  padding-top: 140px;
  font-size: 14px;
}
</style>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"> 

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<h3 style="margin-left: 10px;margin-bottom: 50px">History Persetujuan Pasien</h3>
  <div class="row">
    <div class="col-xs-8">
        <table id="w0" class="table table-striped table-bordered detail-view">
          <tbody>
            <tr><th>Nikes</th><td><?= $model->tpt_tp_nikes ?></td></tr>
            <tr><th>Pegawai</th><td><?= @Pendaftaran::findOne($model->tpt_td_id)->td_tp_nama_kk ?></td></tr>
            <tr><th>Peserta</th><td><?= @Pendaftaran::findOne($model->tpt_td_id)->td_nama_kel ?></td></tr>
            <tr><th>Nomor Rekam Medis</th><td><?= @Pendaftaran::findOne($model->tpt_td_id)->td_rekam_medis ?></td></tr>
            <tr><th>Tujuan</th><td><?= @Yii::$app->params['tujuan'][Pendaftaran::findOne($data['tpt_td_id'])->td_tujuan] ?></td></tr>
            <tr><th>Id Pendaftaran</th><td><?= $model->tpt_td_id ?></td></tr>
            <tr><th>Diagnosa</th><td><?= @ArrayHelper::map($diagnosa, 'tdg_id', 'tdg_penamaan')[$data['tpt_diagnosa']]?></td></tr>
            <tr><th>Tgl Permintaan</th><td><?= $model->tgl_permintaan ?></td></tr>
            <tr><th>Tgl Persetujuan</th><td><?= $model->tgl_persetujuan ?></td></tr>
            <tr><th>Biaya</th><td><?= 'Rp. '.$model->biaya ?></td></tr>
            <tr><th>Catatan Mitra</th><td><?= $model->tpt_catatan_mitra ?></td></tr>
            <tr><th>Biaya Disetujui</th><td><?= 'Rp. '.$model->biaya_disetujui ?></td></tr>
            <tr><th>Catatan Yakes</th><td><?= $model->tpt_catatan_yakes ?></td></tr>
            <tr><th>Flag Status</th><td><?= ($model->tpt_flag_status=='')?'Belum Di proses':@Yii::$app->params['persetujuan'][$model->tpt_flag_status] ?></td></tr>
          </tbody>
        </table>    
    </div>
    <div class="col-xs-2">
        <table id="w1" class="table table-striped table-bordered detail-view">
            <tbody>
                <tr>
                    <th>History Catatan : </th>
                </tr>
                <tr>
                    <td style="min-width: 350px;"><?= $model->history_catatan ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

