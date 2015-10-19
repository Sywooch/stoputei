<?php
use yii\helpers\Url;
$liqpay = Yii::$app->liqpay;
$liqpay->setKeys(Yii::$app->params['payment']['liqpay']['public_key'],
    Yii::$app->params['payment']['liqpay']['private_key']);
if(Yii::$app->request->getQueryParam('type') == 'single') {
    $describe = Yii::t('app', 'Лицензия Регион – активирует все сервисы только для региона регистрации Авиа/Тур агентства. Позволяет работать с туристами только из региона регистрации агентства. Агентство получает в свой кабинет запросы на туры и авиаперелет, отправленные туристами только из региона регистрации агентства. Горящие туры, опубликованные агентством, доступны туристам только из региона регистрации агентства.');
    $html = $liqpay->cnb_form(array(
        'version' => '3',
        'amount' => Yii::$app->user->identity->city->country->bill->single_region_cost,
        'currency' => Yii::$app->user->identity->city->country->bill->currency,
        'description' => Yii::t('app', 'License "Region" ($15 per 3 months)'),
        'order_id' => Yii::$app->user->identity->getId() . '_single',
        'sandbox' => 1,
        'result_url' => Url::to(['/site/index'], true),
        'server_url' => Url::to(['/api/liqpay-callback'], true),
    ));
}else{
    $describe = Yii::t('app', 'Лицензия Вся страна – активирует все сервисы для всех регионов страны регистрации Авиа/Тур агентства. Позволяет работать с туристами всех регионов страны регистрации агентства. Агентство получает в свой кабинет запросы на туры и авиаперелет, отправленные туристами из всех регионов страны регистрации агентства. Горящие туры, опубликованные агентством, доступны всем туристам из страны регистрации агентства.');
    $html = $liqpay->cnb_form(array(
        'version' => '3',
        'amount' => Yii::$app->user->identity->city->country->bill->multiple_region_cost,
        'currency' => Yii::$app->user->identity->city->country->bill->currency,
        'description' => Yii::t('app', 'License "Whole country" ($30 per 3 months)'),
        'order_id' => Yii::$app->user->identity->getId() . '_multiple',
        'sandbox' => 1,
        'result_url' => Url::to(['/site/index'], true),
        'server_url' => Url::to(['/api/liqpay-callback'], true),
    ));
}
?>
<div class="row">
    <div class="col-xs-12 profile payment liqpay">
        <div class="describe-payment">
             <?=$describe;?>
        </div>
        <div>
            <?= $html;?>
        </div>
    </div>
</div>