<?php
use backend\assets\AppAsset;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

dmstr\web\AdminLteAsset::register($this);
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
<style type="text/css">

/*-------------------------------
            LOGIN STYLES
-------------------------------*/

.login-page {
    background: #65cea7 url("/img/site/login-bg.jpg") no-repeat fixed;
    background-size: cover;
    width: 100%;
    height: 100%;
}

.form-signin {
    max-width: 330px;
    margin: 250px auto;
    background: #fff;
    border-radius: 5px;
    -webkit-border-radius: 5px;
}

.form-signin .form-signin-heading {
    margin: 0;
    padding: 25px 15px;
    text-align: center;
    color: #fff;
    position: relative;
}

.sign-title {
    font-size: 24px;
    color: #6bc5a4;
    position: absolute;
    top: 0px;
    left: 0;
    text-align: center;
    width: 100%;
    text-transform: uppercase;
}

.form-signin .checkbox {
    margin-bottom: 14px;
    font-size: 13px;
}

.form-signin .checkbox {
    font-weight: normal;
    color: #fff;
    font-weight: normal;
    font-family: 'Open Sans', sans-serif;
    position: absolute;
    bottom: -50px;
    width: 100%;
    left: 0;
}

.form-signin .checkbox a, .form-signin .checkbox a:hover {
    color: #fff;
}

.form-signin .form-control {
    position: relative;
    font-size: 16px;
    height: auto;
    padding: 10px;
    -webkit-box-sizing: border-box;
    -moz-box-sizing: border-box;
    box-sizing: border-box;
}

.form-signin .form-control:focus {
    z-index: 2;
}

.form-signin input[type="text"], .form-signin input[type="password"] {
    margin-bottom: 15px;
    border-radius: 5px;
    -webkit-border-radius: 5px;
    border: 1px solid #eaeaec;
    background: #eaeaec;
    box-shadow: none;
    font-size: 12px;
}

.form-signin .btn-login {
    background: #6bc5a4;
    color: #fff;
    text-transform: uppercase;
    font-weight: normal;
    font-family: 'Open Sans', sans-serif;
    margin: 20px 0 5px;
    padding: 5px;
    -webkit-transition: all 0.3s;
    -moz-transition: all 0.3s;
    transition: all 0.3s;
    font-size: 30px;
}

.form-signin .btn-login:hover {
    background: #688ac2;
    -webkit-transition: all 0.3s;
    -moz-transition: all 0.3s;
    transition: all 0.3s;
}

.form-signin p {
    text-align: left;
    color: #b6b6b6;
    font-size: 16px;
    font-weight: normal;
}

.form-signin a, .form-signin a:hover {
    color: #6bc5a4;
}

.form-signin a:hover {
    text-decoration: underline;
}

.login-wrap {
    padding: 20px;
    position: relative;
}

.registration {
    color: #c7c7c7;
    text-align: center;
    margin-top: 15px;
}
</style>
<body class="login-page">

<?php $this->beginBody() ?>

    <?= $content ?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
