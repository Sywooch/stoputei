<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\bootstrap\ButtonDropdown;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
$header_css = (in_array(Yii::$app->controller->action->id, ['login','registration']))?'to-top':'';
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>

<?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => Yii::t('app','Stoputei'),
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top '.$header_css,
                    'id' => 'header-navbar'
                ],
            ]);
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right custom-header'],
                'items' => [
                    ['label' => Yii::t('app','Contacts'), 'url' => ['#']],
                    ['label' => Yii::t('app','About'), 'url' => ['/site/about']],
                    Yii::$app->user->isGuest ?
                        ((Yii::$app->controller->action->id == 'login')?
                            ['label' => Yii::t('app','Sign up'), 'url' => ['/site/registration']]:
                            ['label' => Yii::t('app','Login'), 'url' => ['/site/login']]
                        ) :
                        ['label' =>   Yii::$app->user->identity->email,
                            'items' => [
                                ['label' => Yii::t('app','Edit profile'), 'url' => ['/profile/index']],
                                '<li class="divider"></li>',
                                (Yii::$app->user->identity->role == 3)?
                                    ['label' => Yii::t('app','Admin panel'), 'url' => ['/admin/board/users']]:'',
                                ['label' => Yii::t('app','Settings'), 'url' => ['#']],
                                '<li class="divider"></li>',
                                ['label' => Yii::t('app','Logout'),
                                    'url' => ['/site/logout'],
                                    'linkOptions' => ['data-method' => 'post']
                                ],
                            ]
                        ]
                ],
            ]);
            NavBar::end();
        ?>

        <div class="container <?=$header_css;?>">
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; <?=Yii::t('app','Stoputei');?> <?= date('Y') ?></p>
        </div>
    </footer>
    <div id="modal-container" class="modal fade bs-example-modal-md" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-md">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span class="glyphicon glyphicon-remove"></span></button>
            <div class="modal-title"></div>
            <div class="modal-content">
                
            </div>
        </div>
    </div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
