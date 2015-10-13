<?php
use yii\helpers\Url;
$liqpay = Yii::$app->liqpay;
$liqpay->setKeys(Yii::$app->params['payment']['liqpay']['public_key'],
    Yii::$app->params['payment']['liqpay']['private_key']);
if(Yii::$app->request->getQueryParam('type') == 'single') {
    $describe = Yii::t('app', 'License "Region" ($15 per 3 months)');
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
    $describe = Yii::t('app', 'License "Whole country" ($30 per 3 months)');
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
        <div>
            <h4>
                <?=$describe;?>
            </h4>
        </div>
        <div>
            <?= $html;?>
        </div>
    </div>
</div>