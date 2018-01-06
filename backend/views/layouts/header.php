<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
?>

<header class="main-header">

    <?= Html::a('<span class="logo-mini">APP</span><span class="logo-lg">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">


                <!-- Messages: style can be found in dropdown.less-->

                <!-- Tasks: style can be found in dropdown.less -->

                <!-- User Account: style can be found in dropdown.less -->

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="user-image" alt="User Image"/>
                        <span class="hidden-xs"><?php
                            if (Yii::$app->user->isGuest){
                                echo '请登录';
                            }else{
                                echo "欢迎：".Yii::$app->user->identity->username;
                            }
                            ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle"
                                 alt="User Image"/>

                            <p>
                                Yii advanced development

                            </p>
                        </li>
                        <!-- Menu Body -->
                        <li class="user-body">
                            <center class="nowTime"></center>
                            <!--<div class="col-xs-4 text-center">
                                <a href="#"></a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#"></a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#"></a>
                            </div>-->
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">

                            </div>
                            <div class="pull-right">
                                <?php
                                if (Yii::$app->user->isGuest){
                                   echo  "<a class='btn btn-default btn-flat' href=".yii\helpers\Url::to('login').">请登录</a>";
                                }else{
                               echo  Html::a(
                                    '注销登录',
                                    ['/admin/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                );} ?>
                            </div>
                        </li>
                    </ul>
                </li>

                <!-- User Account: style can be found in dropdown.less -->
                <li>
                    <span>&ensp;&ensp;&ensp;&ensp;</span>
                    <!--<a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>-->
                </li>
            </ul>
        </div>
    </nav>
</header>

