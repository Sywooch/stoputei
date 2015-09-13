<?php
use yii\helpers\Html;
use app\models\Pages;

/* @var $this yii\web\View */
$this->title = Yii::t('app','FAQ');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <?php if($page = Pages::find()->where(['name' => 'faq'])->one()):?>
        <h1>
            <?= Html::encode($page->title) ?>
            <?php if(Yii::$app->user->identity->role == 3):?>
                <?=Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-pencil']), \yii\helpers\Url::toRoute(['/site/faq-edit']), ['class' => '']);?>
            <?php endif;?>
        </h1>
        <div>
            <?=$page->body;?>
        </div>
    <?php else:?>
        <h1>
            <?= Html::encode($this->title) ?>
            <?php if(Yii::$app->user->identity->role == 3):?>
                <?=Html::a(Html::tag('span', '', ['class' => 'glyphicon glyphicon-pencil']), \yii\helpers\Url::toRoute(['/site/faq-edit']), ['class' => '']);?>
            <?php endif;?>
        </h1>
        <p>
            <?=Yii::t('app','FAQ');?>
        </p>
    <?php endif;?>
</div>
