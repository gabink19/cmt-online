<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $content string */
?>
<?php 
    $session = Yii::$app->session;
    $user = $session->get('user');

    
    $query = 'SELECT count(*) FROM tbl_notifikasi WHERE tn_link like "%persetujuan%" AND tn_user_mitra="'.@Yii::$app->user->id.'" AND tn_type_notif="0" AND tn_telah_dikirim="1" AND tn_telah_dibaca="0" AND flag_deleted="0"' ;
    $counto = Yii::$app->db->createCommand($query)->queryScalar();

    $query = 'SELECT count(*) FROM tbl_notifikasi WHERE tn_link like "%pendaftaran%" AND tn_user_mitra="'.@Yii::$app->user->id.'" AND tn_type_notif="0" AND tn_telah_dikirim="1" AND tn_telah_dibaca="0" AND flag_deleted="0"' ;
    $counto1 = Yii::$app->db->createCommand($query)->queryScalar();

    $query = 'SELECT count(*) FROM tbl_notifikasi WHERE tn_link like "%billing-final%" AND tn_user_mitra="'.@Yii::$app->user->id.'" AND tn_type_notif="0" AND tn_telah_dikirim="1" AND tn_telah_dibaca="0" AND flag_deleted="0"' ;
    $counto2 = Yii::$app->db->createCommand($query)->queryScalar();

    $query2 = 'SELECT tb_nama_bidang FROM tbl_bidang WHERE tb_id="'.Yii::$app->user->identity->bidang_mitra.'"' ;
    $bidang_mitra = Yii::$app->db->createCommand($query2)->queryScalar();
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">CO</span><span class="logo-lg">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">
				 <?= 
                '
                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bullhorn"></i>
                        <span class="label label-warning" id="notif-count" style="display:none;">'.$counto.'</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header" id="notif-count1">You have 0 notifications</li>
                        <li>
                            <ul class="menu" id="contentNotif">
                                
                            </ul>
                        </li>
                    </ul>
                </li>


                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>
                        <span class="label label-primary" id="notif-count2" style="display:none;">'.$counto1.'</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header" id="notif-count21">You have 0 notifications</li>
                        <li>
                            <ul class="menu" id="contentNotif2">
                                
                            </ul>
                        </li>
                    </ul>
                </li>


                <li class="dropdown notifications-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-cloud"></i>
                        <span class="label label-success" id="notif-count3" style="display:none;">'.$counto2.'</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li class="header" id="notif-count31">You have 0 notifications</li>
                        <li>
                            <ul class="menu" id="contentNotif3">
                                
                            </ul>
                        </li>
                    </ul>
                </li>
                ';?>
                
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?= $directoryAsset ?>/img/avatar5.png" class="user-image" alt="User Image"/>
                        <span class="hidden-xs"><?= $user['username'] ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="<?= $directoryAsset ?>/img/avatar5.png" class="img-circle"
                                 alt="User Image"/>

                            <p>
                                <?= $user['nama'] ?>
                                <small><?= $bidang_mitra ?></small>
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-right">
                                <?= Html::a(
                                    'Sign out',
                                    ['/site/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
<script type="text/javascript">
	 $( document ).ready(function() {
        checkCount();
        checkCount1();
        checkCount2();
        checkNotif();
        checkNotif1();
        checkNotif2();
        setInterval(function(){ checkCount(); }, 3000);
        setInterval(function(){ checkCount1(); }, 3000);
        setInterval(function(){ checkCount2(); }, 3000);
        setInterval(function(){ checkNotif(); }, 10000);
        setInterval(function(){ checkNotif1(); }, 10000);
        setInterval(function(){ checkNotif2(); }, 10000);
    });
    function checkCount() {
        count = $('#notif-count').text();
        if (count==0||count=='0') {
            $('#notif-count').hide();
        }else if (count>0) {
            $('#notif-count').show();
        }
    }
    function checkCount1() {
        count = $('#notif-count2').text();
        if (count==0||count=='0') {
            $('#notif-count2').hide();
        }else if (count>0) {
            $('#notif-count2').show();
        }
    }
    function checkCount2() {
        count = $('#notif-count3').text();
        if (count==0||count=='0') {
            $('#notif-count3').hide();
        }else if (count>0) {
            $('#notif-count3').show();
        }
    }
    function checkNotif() {
        $.ajax({
            url: '<?= Url::to(["site/check-notif"]) ?>'+'&link=persetujuan', 
            success: function(result){
                var obj = eval('(' + result + ')');
                $('#notif-count').text(obj.jumlah);
                $('#notif-count1').text('You have '+obj.jumlah+' notifications');
                $('#contentNotif').empty();
                $.each(obj.data, function( index, value ) {
                    $('#contentNotif').append('<li title=" '+value.tn_judul+' - \"'+value.tn_teks+'\""><a href="'+value.tn_link+'"><i class="fa fa-envelope text-yellow"></i>   '+value.tn_judul+' - "'+value.tn_teks+'"</a></li>');
                });
            }
        });
    }
    function checkNotif1() {
        $.ajax({
            url: '<?= Url::to(["site/check-notif"]) ?>'+'&link=pendaftaran',  
            success: function(result){
                var obj = eval('(' + result + ')');
                $('#notif-count2').text(obj.jumlah);
                $('#notif-count21').text('You have '+obj.jumlah+' notifications');
                $('#contentNotif2').empty();
                $.each(obj.data, function( index, value ) {
                    $('#contentNotif2').append('<li title=" '+value.tn_judul+' - \"'+value.tn_teks+'\""><a href="'+value.tn_link+'"><i class="fa fa-envelope text-blue"></i>   '+value.tn_judul+' - "'+value.tn_teks+'"</a></li>');
                });
            }
        });
    }
    function checkNotif2() {
        $.ajax({
            url: '<?= Url::to(["site/check-notif"]) ?>'+'&link=billing-final',  
            success: function(result){
                var obj = eval('(' + result + ')');
                $('#notif-count3').text(obj.jumlah);
                $('#notif-count31').text('You have '+obj.jumlah+' notifications');
                $('#contentNotif3').empty();
                $.each(obj.data, function( index, value ) {
                    $('#contentNotif3').append('<li title=" '+value.tn_judul+' - \"'+value.tn_teks+'\""><a href="'+value.tn_link+'"><i class="fa fa-envelope text-green"></i>   '+value.tn_judul+' - "'+value.tn_teks+'"</a></li>');
                });
            }
        });
    }
    function clearconsole()
	 { 
	   console.log(window.console);  
	   if(window.console )
	   {    
	     // console.clear();  
	   }
	 }
</script>
