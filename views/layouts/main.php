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
switch(Yii::$app->controller->action->id){
    case 'login':
    case 'registration':
        $header_css = 'to-top';
        break;
    case 'welcome':
        $header_css = 'welcome';
        break;
    default:
        $header_css = '';
        break;
}
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
                'brandLabel' => Html::img('/images/logo.png', ['class' => 'img-response main-logo']),
                'brandUrl' => \yii\helpers\Url::home(),
                'options' => [
                    'class' => (Yii::$app->controller->action->id == 'welcome')?'navbar-inverse navbar-fixed-top welcome':'navbar-inverse navbar-fixed-top',
                    'id' => 'header-navbar',
                ],
            ]);
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right custom-header'],
                'items' => [
                    ['label' => \app\components\PaymentPackage::widget()],
                    ['label' => Yii::t('app','Contacts'), 'url' => ['/site/contact']],
                    ['label' => Yii::t('app','About'), 'url' => ['/site/about']],
                    ['label' => Yii::t('app','FAQ'), 'url' => ['/site/faq']],
                    Yii::$app->user->isGuest ?
                        ((Yii::$app->controller->action->id == 'login')?
                            ['label' => Yii::t('app','Sign up'), 'url' => ['/site/registration']]:
                            ['label' => Yii::t('app','Login'), 'url' => ['/site/login']]
                        ) :
                        ['label' =>   Yii::t('app', 'Cabinet').' № '.Yii::$app->user->identity->getId().'<br><span><img src="/images/flags/48/'.Yii::$app->user->identity->city->country->A2.'.png">'.Yii::$app->user->identity->city->name.'</span>',
                            'items' => [
                                ['label' => Yii::t('app','Edit profile'), 'url' => ['/profile/index']],
                                (Yii::$app->user->identity->role == 3)?
                                    ['label' => Yii::t('app','Admin panel'), 'url' => ['/admin/board/managers']]:'',
                                //['label' => Yii::t('app','Settings'), 'url' => ['#']],

                                ['label' => Yii::t('app','Logout'),
                                    'url' => ['/site/logout'],
                                    'linkOptions' => ['data-method' => 'post']
                                ],
                            ]
                        ]
                ],
                'encodeLabels' => false
            ]);
            NavBar::end();
        ?>

        <div class="container <?=$header_css;?>">
            <?= $content ?>
        </div>
    </div>

    <footer class="footer <?=(Yii::$app->controller->action->id == 'welcome')?'welcome':'';?>">
        <div class="container">
            <p class="pull-left">&copy; <?=Yii::t('app','Stoputei');?> <?= date('Y') ?><span class="reserved"><?=Yii::t('app', 'All rights reserved');?></span></p>
        </div>
    </footer>
    <div class="global loader-bg hide"><img src="/images/loader.gif"></div>
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
