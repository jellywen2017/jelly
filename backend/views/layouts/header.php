<?php
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */
?>
<style type="text/css">
    .sidebar-collapse a.logo{ display: none ; }
    .sidebar-collapse div.navbar-custom-menu{ display: none ; }
</style>

<script type="text/javascript">
    $(function(){

    });
</script>

<header class="main-header">

     <?= Html::a('<span class="logo-mini">导航</span><span class="logo-lg">' . Yii::$app->name . '</span>', Yii::$app->homeUrl, ['class' => 'logo']) ?> 

    <nav class="navbar navbar-static-top" role="navigation">

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">
                <!-- 个人博客 -->
<!--                 <li class=" ">
                    <a href="https://jellywen.cn" style="font-size: 16px;" >博客</a>
                </li> -->
                <!-- 工具 -->
<!--                 <li class=" ">
                    <a href="https://jellywen.cn" style="font-size: 16px;" >工具</a>
                </li> -->

                <!-- 个人github -->
                <li class=" ">
                    <a href="https://github.com/jellywen2017" style="font-size: 16px;" >GitHub</a>
                </li>
                <!-- 个人dockerhub -->
                <li class=" ">
                    <a href="https://hub.docker.com/u/jellywen" style="font-size: 16px;" >DockerHub</a>
                </li>

                <li class=" ">
                    <a href="/site/logout" data-method="post" style="font-size: 16px;" >退出</a>
                </li>

            
                <!-- User Account: style can be found in dropdown.less -->
<!--                 <li>
                    <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li> -->
            </ul>
        </div>
    </nav>
</header>
