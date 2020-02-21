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


                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?= Yii::getAlias('@web') ?>/img/man-light.png" class="user-image" alt="User Image" />
                        <span class="hidden-xs"><?= Yii::$app->user->identity->username; ?></span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="<?= Yii::getAlias('@web') ?>/img/man-light.png" class="img-circle" alt="User Image" />

                            <p>
                                <?= Yii::$app->user->identity->username; ?>
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <!-- <li class="user-body">
                            <div class="col-xs-4 text-center">
                                <a href="#">Followers</a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#">Sales</a>
                            </div>
                            <div class="col-xs-4 text-center">
                                <a href="#">Friends</a>
                            </div>
                        </li> -->
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <?php if (!Yii::$app->user->isGuest) : ?>
                                <div class="pull-left">
                                    <?= Html::a(
                                        'เปลี่ยนรหัสผ่าน',
                                        ['/site/request-password-reset'],
                                        ['class' => 'btn btn-default btn-flat']
                                    ) ?>
                                </div>
                            <?php endif; ?>
                            <?php if (!Yii::$app->user->isGuest) : ?>
                                <div class="pull-right">
                                    <?= Html::a(
                                        'ออกจากระบบ',
                                        ['/site/logout'],
                                        ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                    ) ?>
                                </div>
                            <?php endif; ?>

                            <?php if (Yii::$app->user->isGuest) : ?>
                                <div class="pull-right">
                                    <?= Html::a(
                                        'เข้าสู่ระบบ',
                                        ['/site/logout'],
                                        ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                    ) ?>
                                </div>
                            <?php endif; ?>
                        </li>
                    </ul>
                </li>


            </ul>
        </div>
    </nav>
</header>