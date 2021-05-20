<?php
use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use frontend\controllers\SiteController;

/* @var $this \yii\web\View */
/* @var $content string */


if (Yii::$app->controller->action->id === 'portal') { 
/**
 * Do not use this code in your template. Remove it. 
 * Instead, use the code  $this->layout = '//main-login'; in your controller.
 */
    echo $this->render(
        'main-portal',
        ['content' => $content]
    );
}else if (Yii::$app->controller->action->id === 'contact') { 
/**
 * Do not use this code in your template. Remove it. 
 * Instead, use the code  $this->layout = '//main-login'; in your controller.
 */
    echo $this->render(
        'main-contact',
        ['content' => $content]
    );
}else if (Yii::$app->controller->action->id === 'information') { 
/**
 * Do not use this code in your template. Remove it. 
 * Instead, use the code  $this->layout = '//main-login'; in your controller.
 */
    echo $this->render(
        'main-information',
        ['content' => $content]
    );
}else if (Yii::$app->user->isGuest && Yii::$app->controller->action->id === 'login') { 
/**
 * Do not use this code in your template. Remove it. 
 * Instead, use the code  $this->layout = '//main-login'; in your controller.
 */
    echo $this->render(
        'main-login',
        ['content' => $content]
    );
} else {

    if (class_exists('backend\assets\AppAsset')) {
        backend\assets\AppAsset::register($this);
    } else {
        app\assets\AppAsset::register($this);
    }

    dmstr\web\AdminLteAsset::register($this);

    $directoryAsset = Yii::$app->assetManager->getPublishedUrl('@vendor/almasaeed2010/adminlte/dist');
    ?>
    <?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.3/jquery.mCustomScrollbar.min.css'>
    <link href="css/chat.css" rel="stylesheet">
    <body class="hold-transition skin-blue sidebar-mini">
    <?php $this->beginBody() ?>
    <div class="wrapper">

        <?= $this->render(
            'header.php',
            ['directoryAsset' => $directoryAsset]
        ) ?>

        <?= $this->render(
            'left.php',
            ['directoryAsset' => $directoryAsset]
        )
        ?>

        <?= $this->render(
            'content.php',
            ['content' => $content, 'directoryAsset' => $directoryAsset]
        ) ?>

    </div>
    <?php
        $session = Yii::$app->session;
        $crud_akses = $session->get('crud_akses');
        $newvalue = [];
        if (is_array($crud_akses)) {
            foreach ($crud_akses as $key => $value) {
                $newvalue[] = str_replace('/crud', '', $value['route']);
            }
            if (!in_array(Yii::$app->controller->id, $newvalue)) {
                $js = <<<JS
                $(function() {
                    $.each( $('a'), function(i, item){
                        try {
                            href = $(this).attr('href');
                            tag = $(this).attr('href').split('?r=');
                            clearing = tag[1].split('%2F');
                            clearing = clearing[1].split('&');
                            if(clearing[0]=='create' || clearing[0]=='delete' || clearing[0]=='update'){
                                $(this).remove();
                            }
                        }catch(err){
                                // console.log(err)
                        }
                    });
                });
JS;
                $this->registerJs($js);
            }
        }
        $js=<<<js
        $('.modal-dialog').width(400);
        $('.modalButton').on('click', function () {
            $('#modal').modal('show')
                    .find('#modalContent');
        });
js;
        $this->registerJs($js);    
    ?>
    <?php
        $jsnotif=<<<js
         $( document ).ready(function() {
            $('.modalButton').trigger('click');
        });
js;
        if ($session->get('notif') !== '') {
            $notif = $session->get('notif');
            Modal::begin([
                'header' => 'Info',
                'id' => 'modal',
                'size' => 'modal-lg',
                'headerOptions' => ['style'=>'display:none;'],
            ]);
            echo "<div id='modalContent'></div>
                    <div class='modal-body' style='text-align:center;'>
                    <div class='check_mark'>
                      <div class='sa-icon sa-success animate'>
                        <span class='sa-line sa-tip animateSuccessTip'></span>
                        <span class='sa-line sa-long animateSuccessLong'></span>
                        <div class='sa-placeholder'></div>
                        <div class='sa-fix'></div>
                      </div>
                    </div>
                        <p><b>$notif Berhasil.<b></p>
                    </div>
                    <div class='modal-footer' style='padding: 15px 15px 1px 15px !important;'>
                        <button type='button' class='btn btn-default' data-dismiss='modal'>Tutup</button>
                    </div>";
            Modal::end();

            $this->registerJs($jsnotif);
            $session->set('notif','');  
        }
    ?>
    <a class="btn btn-info modalButton" style="display: none;"></a>
    <div id="float" class="fixed">
            <div class="col-lg-4" id="chatingclose" style="display: block;">
                <a href="#" type="button" id="openchat" class="float notification">
                <i class="fa fa-comments my-float"></i>
                <?php
                $new = SiteController::actionNotifChat(); 
                if ($new>0) {
                  echo "<span class=\"badge\">*</span>";
                }
                ?>
                </a>            
            </div>
            <div class="col-lg-4" id="listuser" style="display: none;">
                <!--
                    Inspired by https://dribbble.com/supahfunk
                    -->
                   <section class="avenue-messenger">
                      <div class="menu">
                       <div class="items"><span>
                         <a href="#" title="Minimize">&mdash;</a><br>
                    <!--     
                         <a href="">enter email</a><br>
                         <a href="">email transcript</a><br>-->
                         <a href="#" type="button" id="closechat" title="End Chat">&#10005;</a>
                         
                         </span></div>
                        <div class="button" id="titiktitik">...</div>
                      </div>

                    <div class="agent-face">
                      <div class="half">
                       <img class="agent circle" src="image/chat.png" alt="CHAT">
                      </div>
                    </div>
                    <div class="chat">
                      <div class="chat-title">
                        <h1>Please Select user</h1>
                        <h2>For start chat</h2>
                      <!--  <figure class="avatar">
                          <img src="image/avatar.png" /></figure>-->
                      </div>
                      <div class="messagess" style="overflow: auto;">
                        <ul class="ulchat" id="lists">
                          
                          <!-- <li class="lichat"><a href="#" onclick="saveRoom(1)">News</a></li>
                          <li class="lichat"><a href="#" onclick="saveRoom(1)">Contact</a></li>
                          <li class="lichat"><a href="#" onclick="saveRoom(1)">About</a></li> -->
                        </ul>
                      </div>
                    </div>
                  </section>            
            </div>
            <div class="col-lg-4" id="chating" style="display: none;">
                <!--
                    Inspired by https://dribbble.com/supahfunk
                    -->
                   <section class="avenue-messenger">
                      <div class="menu">
                       <div class="items"><span>
                         <a href="#" title="Back To List User" id="backtolist">&mdash;</a><br>
                    <!--     
                         <a href="">enter email</a><br>
                         <a href="">email transcript</a><br>-->
                         <a href="#" type="button" id="closechat1" title="End Chat">&#10005;</a>
                         
                         </span></div>
                        <div class="button" id="titiktitik">...</div>
                      </div>
                    <div class="agent-face">
                      <div class="half">
                       <img class="agent circle" src="image/avatar.png" alt="Jesse Tino"></div>
                    </div>
                    <div class="chat">
                      <div class="chat-title">
                        <h1 id="namaLawan">Big Boss</h1>
                        <!-- <h2>Admin</h2> -->
                      <!--  <figure class="avatar">
                          <img src="image/avatar.png" /></figure>-->
                      </div>
                      <div class="messages">
                        <div class="messages-content"></div>
                      </div>
                      <div class="message-box">
                        <textarea type="text" class="message-input" placeholder="Type message..."></textarea>
                        <button type="button" class="message-submit" style="right: 60px;font-size: 15px;top: 6px;" id="attach"><i class="fa fa-paperclip" aria-hidden="true"></i></button>
                        <form name="photo" id="imageUploadForm" enctype="multipart/form-data" method="post">
                            <input type="file" id="upload" name="upload" style="display:none">
                            <button type="submit" style="display:none" id="submitattach"></button>
                        </form>
                        <button type="submit" class="message-submit" id="sent">Send</button>
                      </div>
                    </div>
                  </section>            
              </div>
    </div>
    <audio id="carteSoudCtrl">
      <source src="notif.mp3" type="audio/mpeg">
      Your browser does not support the audio element.
    </audio>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.3/jquery.mCustomScrollbar.concat.min.js'></script>
    <script type="text/javascript">
    var $messages = $('.messages-content'),
        d, h, m,
        i = 0;
    var ID = 0;
    var ROOM = 0;
    var checknewchat = 0;
    var firsttime = 0;
    $(window).load(function() {
      $messages.mCustomScrollbar();
      // getChat();
      setInterval(function() {
        if (checknewchat==1) {
          checknew();
        }
      }, 2000);
      // listUser();
    });
    function checknew() {
        $.ajax({
            url: "<?= Url::to(['site/checknew'])?>&lastid="+ID+"&idroom="+ROOM+"&user=<?= Yii::$app->user->identity->id?>",
            type: "post",
            success: function (response) {
                if (response!='false') {
                  var obj= eval("(" + response + ")");
                  id = '<?= Yii::$app->user->identity->id?>';
                  $.each(obj, function( index, value ) {
                    if (value.userId==id) {
                        $('<div class="message message-personal">' + value.message + '</div>').appendTo($('.mCSB_container')).addClass('new');
                        setDate(value.updateDate);
                    }else{
                        $('#namaLawan').text(value.nama);
                        $('<div class="message new"><figure class="avatar"><img src="image/avatar.png" /></figure>' + value.message + '</div>').appendTo($('.mCSB_container')).addClass('new');
                        setDate(value.updateDate);
                        ID = value.id;
                    }
                  });
                  updateScrollbar();
                  $('#carteSoudCtrl')[0].play();
                }
                  // setTimeout(function() {
                  //   fakeMessage();
                  // }, 1000 + (Math.random() * 20) * 100);
            },
            error: function(jqXHR, textStatus, errorThrown) {
               console.log(textStatus, errorThrown);
            }
        });
    }
    function getChat(room) {
        $('.mCSB_container').empty();
        $.ajax({
            url: "<?= Url::to(['site/getchat'])?>",
            type: "post",
            data :{ 
                    'room'     : room, //Store name fields value
                  },
            success: function (response) {
                  var obj= eval("(" + response + ")");
                  id = '<?= Yii::$app->user->identity->id?>';
                  $.each(obj, function( index, value ) {
                    
                    if (value.userId==id) {
                        $('<div class="message message-personal">' + value.message + '</div>').appendTo($('.mCSB_container')).addClass('new');
                        setDate(value.updateDate);
                    }else{
                        $('#namaLawan').text(value.nama);
                        $('<div class="message new"><figure class="avatar"><img src="image/avatar.png" /></figure>' + value.message + '</div>').appendTo($('.mCSB_container')).addClass('new');
                        setDate(value.updateDate);
                        ID = value.id;
                    }
                  });
                  $('.message-input').val(null);
                  $('.badge').hide();
                  updateScrollbar();
                  checknewchat=1;
                  // setTimeout(function() {
                  //   fakeMessage();
                  // }, 1000 + (Math.random() * 20) * 100);
            },
            error: function(jqXHR, textStatus, errorThrown) {
               console.log(textStatus, errorThrown);
            }
        });
    }
    function listUser(){
        id='<?= Yii::$app->user->identity->id?>';
        var datanya = { //Fetch form data
            'id'     : id, //Store name fields value
        };
       $.ajax({
            url: "<?= Url::to(['site/listuser'])?>",
            type: "post",
            data: datanya,
            success: function (response) {
                  var obj= eval("(" + response + ")");
                  $('#lists').empty();
                  $.each(obj, function( index, value ) {
                    $('<li class="lichat"><a id="clickme" href="#" onclick="saveRoom(\''+index+'_'+id+'\',\''+value+'\')">'+value+'</a></li>').appendTo($('#lists'));
                  });
                  $('#clickme').trigger('click')
            },
            error: function(jqXHR, textStatus, errorThrown) {
               console.log(textStatus, errorThrown);
            }
        });
    }
    function saveRoom(room,namanya) {
      $('#namaLawan').text(namanya);
      getChat(room);
      ROOM = room;
      $('#listuser').hide(500);
      $('#chating').show(500);
      $('#chatingclose').hide(500);
    }

    $( "#closechat" ).click(function() {
      close();
      $('#titiktitik').trigger('click')
    });
    $( "#closechat1" ).click(function() {
      close();
      $('#titiktitik').trigger('click')
    });

    $( "#openchat" ).click(function() {
      open();
    });

    $( "#backtolist" ).click(function() {
      $('#titiktitik').trigger('click')
      open();
    });

    function close(){
        $('#chating').hide(500);
        $('#chatingclose').show(500);
        $('#listuser').hide(500);
        // checknewchat=0;
        // ID = 0;
    }
    function open(){
        listUser();
        $('#listuser').hide(500);
        $('#chatingclose').hide(500);
        $('#chating').hide(500);
        checknewchat=0;
        ID = 0;
    }
    function updateScrollbar() {
      $messages.mCustomScrollbar("update").mCustomScrollbar('scrollTo', 'bottom', {
        scrollInertia: 10,
        timeout: 0
      });
    }

    function setDate(date){
        $('<div class="timestamp">' +date+ '</div>').appendTo($('.message:last'));
        $('<div class="checkmark-sent-delivered">&check;</div>').appendTo($('.message:last'));
        $('<div class="checkmark-read">&check;</div>').appendTo($('.message:last'));
    }

    function insertMessage() {
      msg = $('.message-input').val();
      if ($.trim(msg) == '') {
        return false;
      }
        var datanya = { //Fetch form data
            'id'     : '<?= Yii::$app->user->identity->id?>', //Store name fields value
            'pesan'     : msg, //Store name fields value
            'room'     : ROOM, //Store name fields value
        };
        $.ajax({
            url: "<?= Url::to(['site/sendchat'])?>",
            type: "post",
            data: datanya ,
            success: function (response) {
                  $('<div class="message message-personal">' + msg + '</div>').appendTo($('.mCSB_container')).addClass('new');
                  var obj= eval("(" + response + ")");
                  setDate(obj.hour);
                  console.log(obj)
                  $('.message-input').val(null);
                  updateScrollbar();
                  // setTimeout(function() {
                  //   fakeMessage();
                  // }, 1000 + (Math.random() * 20) * 100);
            },
            error: function(jqXHR, textStatus, errorThrown) {
               console.log(textStatus, errorThrown);
            }
        });
    }

    $('#sent').click(function() {
      insertMessage();
    });


    $('#attach').click(function() {
      // insertMessage();
      $('#upload').trigger('click');
    });

    $("#upload").on("change", function() {
      // $("#imageUploadForm").submit();
      $("#submitattach").trigger('click');
      // var formData = new FormData($('#imageUploadForm'));
        // console.log(formData);
    });

    $('#imageUploadForm').submit(function() {
        path = $("#upload").val();
        var array = [];
        var file_data = $('#upload').prop('files')[0];
        var form_data = new FormData();                  
        form_data.append('file', file_data);
        var datanya = 'id=<?= Yii::$app->user->identity->id?>&room='+ROOM;      
        // form_data.push(datanya);
        $.ajax({
            url: "<?= Url::to(['site/sendfile'])?>&"+datanya,
            type: "post",
            data: form_data,
            contentType: false,
            cache: false,
            processData:false,
            success: function (response) {
                  var obj= eval("(" + response + ")");
                  $('<div class="message message-personal">' + obj.name + '</div>').appendTo($('.mCSB_container')).addClass('new');
                  setDate(obj.hour);
                  console.log(obj)
                  $('.message-input').val(null);
                  updateScrollbar();
                  // setTimeout(function() {
                  //   fakeMessage();
                  // }, 1000 + (Math.random() * 20) * 100);
            },
            error: function(jqXHR, textStatus, errorThrown) {
               console.log(textStatus, errorThrown);
            }
        });
        return false
    });

    $(window).on('keydown', function(e) {
      if (e.which == 13) {
        insertMessage();
        return false;
      }
    })

    $('.button').click(function(){
      $('.menu .items span').toggleClass('active');
       $('.menu .button').toggleClass('active');
    });
    </script>
    <?php $this->endBody() ?>
    </body>
    </html>
    <?php $this->endPage() ?>
<?php } ?>
