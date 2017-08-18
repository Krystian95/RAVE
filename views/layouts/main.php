<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\helpers\Url;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="shortcut icon" href="<?php echo Yii::$app->getHomeUrl(); ?>css/images/favicon.ico" type="image/x-icon" />
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>

        <?php $this->beginBody() ?>
        <div class="wrap">
            <?php
            NavBar::begin([
                'brandLabel' => 'RAVE',
                'brandUrl' => ['/site'],
                'brandOptions' => [
                    'class' => 'site-title'
                ],
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            $menuItems = [
                ['label' => 'Home', 'url' => ['/site']],
                ['label' => 'About', 'url' => ['/site/about']]
            ];
            ?>

            <div id="search-box-menu" class="input-group col-lg-4">
                <input type="text" id="query-value-menu" class="query-value form-control" placeholder="Search for..." value="" />
                <span class="input-group-btn">
                    <a href="<?= Url::home() ?>" id="button-search-menu" class="button-search btn btn-default">Search <span class="glyphicon glyphicon-search" aria-hidden="true"></span></a>
                </span>
            </div>

            <?php
            if (Yii::$app->user->isGuest) {
                $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
                $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
            } else {
                $menuItems[] = [
                    'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post']
                ];
            }
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => $menuItems,
            ]);
            NavBar::end();
            ?>

            <div class="container"> 
                <?=
                Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ])
                ?>
                <?= $content ?>
            </div>
        </div>

        <footer class="footer">
            <div class="container">
                <p class="pull-left">&copy; RAVE <?= date('Y') ?></p>
                <p class="pull-right">Powered by
                    <a href="mailto:cristian.romanello@studio.unibo.it" target="_blank">Cristian Romanello</a> e 
                    <a href="mailto:lorenzo.lanzarone@studio.unibo.it" target="_blank">Lorenzo Lanzarone</a>
                </p>
            </div>
        </footer>

        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
