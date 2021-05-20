<?php

/**
 * @var string $content
 * @var \yii\web\View $this
 */

use yii\helpers\Html;
use backend\models\Menu;

backend\assets\AppAsset::register($this);
$bundle = yiister\gentelella\assets\Asset::register($this);

if (Yii::$app->user->isGuest) {
    $username='guest';
}else{
    $username=Yii::$app->user->identity->username;
}
// echo "<pre>"; print_r($model);echo "</pre>";
// die();
?>
<?php $this->beginPage(); ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta charset="<?= Yii::$app->charset ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="nav-<?= !empty($_COOKIE['menuIsCollapsed']) && $_COOKIE['menuIsCollapsed'] == 'true' ? 'sm' : 'md' ?>" >
<?php $this->beginBody(); ?>
<div class="container body">

    <div class="main_container">
    <?php 
        if(!Yii::$app->user->isGuest){
            $div = '<div class="col-md-3 left_col">';
        }
        else
        {
            echo '<style>body{background:white!important} .right_col{background:white !important;}</style>';
            $div = '<div class="col-md-3 left_col hide">';
        }
        echo $div;
        // echo "<pre>"; print_r($_SERVER['SCRIPT_NAME']); die();
    ?>
            <div class="left_col scroll-view">

                <div class="navbar nav_title" style="border: 0;">
                    <a href="<?php echo $_SERVER['SCRIPT_NAME'];?>" class="site_title"><i class="fa fa-paw"></i> <span><?php echo Yii::$app->params['project_title']; ?></span></a>
                </div>
                <div class="clearfix"></div>

                <!-- menu prile quick info -->
                <div class="profile">
                    <div class="profile_pic">
                        <img src="https://png.pngtree.com/svg/20170602/person_1058425.png" alt="..." class="img-circle profile_img">
                    </div>
                    <div class="profile_info">
                        <span>Welcome,</span>
                        <h2><?php echo $username;?></h2>
                    </div>
                </div>
                <!-- /menu prile quick info -->

                <br />

                <!-- sidebar menu -->
                <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

                    <div class="menu_section">
                        <?php
                        $session = Yii::$app->session;
                        $user = $session->get('user');
                        // echo "<pre>"; print_r($user);echo "</pre>";
                        ?>
                        <h3>General</h3>
                        <?=
                        \yiister\gentelella\widgets\Menu::widget(
                            $user['menu']
                        )
                        ?>
                    </div>

                </div>
                <!-- /sidebar menu -->
            </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
            <?php
                if(!Yii::$app->user->isGuest)
                    $div = '<div class="nav_menu">';
                else
                    $div = '<div class="nav_menu hide">';

                echo $div;

                echo Html::beginForm(['/site/logout'], 'post',['id'=>'form-logout','class'=>'hide'])
                . Html::submitButton(
                        'Logout (' .  $username . ')', ['class' => 'btn btn-link logout btn-logout']
                )
                . Html::endForm();
            ?>
                <nav class="" role="navigation">
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>

                    <ul class="nav navbar-nav navbar-right">
                        <li class="">
                            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <img src="http://placehold.it/128x128" alt=""><?php echo $username;?>
                                <span class=" fa fa-angle-down"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-usermenu pull-right">
                                <li>
                                <a href="javascript:logout();"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>

        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
            <?php if (isset($this->params['h1'])): ?>
                <div class="page-title">
                    <div class="title_left">
                        <h1><?= $this->params['h1'] ?></h1>
                    </div>
                    <div class="title_right">
                        <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search for...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">Go!</button>
                            </span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <div class="clearfix"></div>

            <?= $content ?>
        </div>
        <!-- /page content -->
        <!-- footer content -->
        <footer>
            <div class="pull-right">
            </div>
            <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
    </div>

</div>

<div id="custom_notifications" class="custom-notifications dsp_none">
    <ul class="list-unstyled notifications clearfix" data-tabbed_notifications="notif-group">
    </ul>
    <div class="clearfix"></div>
    <div id="notif-group" class="tabbed_notifications"></div>
</div>
<script type="text/javascript">
    function logout(){
        $("#form-logout").submit();
    }
</script>
<!-- /footer content -->
<?php 
if (class_exists('yii\debug\Module')) {
    $this->off(\yii\web\View::EVENT_END_BODY, [\yii\debug\Module::getInstance(), 'renderToolbar']);
}
$this->endBody();
 ?>
</body>
</html>
<?php $this->endPage(); ?>
