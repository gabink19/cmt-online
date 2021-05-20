<?php 
use frontend\models\Pendaftaran;
use backend\models\Diagnosa;
    $d = date('d',strtotime($peserta['tp_tgl_lahir']));
    $m = Yii::$app->params['array_bulan'][date('m',strtotime($peserta['tp_tgl_lahir']))];
    $y = date('Y',strtotime($peserta['tp_tgl_lahir']));
    $peserta['tp_tgl_lahir'] = ' '.$d.' '.$m.' '.$y;
?>
<style type="text/css">
th {
    background: #e5131d;
    color: white;
}
h3 {
  text-align: left;
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
<h3 style="margin-left: 10px;margin-bottom: 50px">History Pengobatan Pasien</h3>
  <div class="row col-xs-12">
    <div class="col-xs-2"><label>NIKES </label></div><div class="col-xs-2"><label>: <?= $peserta['tp_nikes'] ?></label></div>
    <div class="col-xs-2"><label>JENIS KELAMIN </label></div><div class="col-xs-2"><label>: <?= Yii::$app->params['jkelamin'][$peserta['tp_jenis_kelamin']] ?></label></div>
    <div class="col-xs-2"><label>USIA </label></div><div class="col-xs-2"><label>: <?= $peserta['tp_umur'] ?> TAHUN</label></div>


    <div class="col-xs-2"><label>NAMA PESERTA </label></div><div class="col-xs-2"><label>: <?= $peserta['tp_nama_kel'] ?></label></div>
    <div class="col-xs-2"><label>TGL LAHIR </label></div><div class="col-xs-2"><label>: <?= $peserta['tp_tgl_lahir'] ?></label></div>
    <div class="col-xs-2"><label>KATEGORI HOST </label></div><div class="col-xs-2"><label>: <?= Yii::$app->params['kategori_host'][$peserta['kategori_host']] ?></label></div>

    <div class="col-xs-12">
      <div class="table-responsive">
        <table summary="This table shows how to create responsive tables using Bootstrap's default functionality" class="table table-bordered table-hover">
          <thead>
            <tr>
              <th>TANGGAL</th>
              <th>TUJUAN</th>
              <th>DIAGNOSA</th>
              <th>MITRA</th>
              <th>BIAYA</th>
            </tr>
          </thead>
          <tbody>
            <?php 
              foreach ($model as $key => $value) {
                $d = date('d',strtotime( $value['tgl_billing']));
                $m = Yii::$app->params['array_bulan'][date('m',strtotime( $value['tgl_billing']))];
                $y = date('Y',strtotime( $value['tgl_billing']));
                $tgl = ' '.$d.' '.$m.' '.$y;
                $tujuan = Yii::$app->params['tujuan'][Pendaftaran::findOne($value['tbs_td_id'])->td_tujuan];
                $diagnosa = Diagnosa::findOne($value['tbs_diagnosa'])->tdg_penamaan;
                $mitra = $value['tbs_nama_mitra'];
                $biaya = $value['tbs_biaya'];
                if (strpos($biaya, '.')==true) {
                  $biaya = str_replace('.', '', $biaya);
                }
                $biaya = number_format($biaya,0,",",".");
                echo "<tr>
                  <td>$tgl</td>
                  <td>$tujuan</td>
                  <td>$diagnosa</td>
                  <td>$mitra</td>
                  <td>Rp. $biaya</td>
                </tr>";
              }
            ?>
          </tbody>
          <tfoot>
            <tr>
              <td colspan="5" class="text-center">CMT-ONLINE <?php echo date('Y') ?>.</td>
            </tr>
          </tfoot>
        </table>
      </div><!--end of .table-responsive-->

