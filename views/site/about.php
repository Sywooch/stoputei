<?php
use yii\helpers\Html;
use app\models\Pages;

/* @var $this yii\web\View */
$this->title = Yii::t('app','About');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <?php if($page = Pages::find()->where(['name' => 'about'])->one()):?>
        <h1>
            <?= Html::encode($page->title) ?>
            <?php if(!Yii::$app->user->isGuest):?>
                <?php if(Yii::$app->user->identity->role == 3):?>
                    <?=Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-pencil']), \yii\helpers\Url::toRoute(['/site/about-edit']), ['class' => '']);?>
                <?php endif;?>
            <?php endif;?>
        </h1>
        <div>
            <?=$page->body;?>
        </div>
    <?php else:?>
        <h1>
            <?= Html::encode($this->title) ?>
            <?php if(!Yii::$app->user->isGuest):?>
                <?php if(Yii::$app->user->identity->role == 3):?>
                    <?=Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-pencil']), \yii\helpers\Url::toRoute(['/site/about-edit']), ['class' => '']);?>
                <?php endif;?>
            <?php endif;?>
        </h1>
        <p>
            <?=Yii::t('app','About');?>
        </p>
    <?php endif;?>
</div>
