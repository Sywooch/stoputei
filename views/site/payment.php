<?php
use yii\helpers\Url;
$liqpay = Yii::$app->liqpay;
$liqpay->setKeys(Yii::$app->params['payment']['liqpay']['public_key'],
    Yii::$app->params['payment']['liqpay']['private_key']);
$html = $liqpay->cnb_form(array(
    'version'        => '3',
    'amount'         => '1',//Yii::$app->user->identity->city->country->bill->single_region_cost,
    'currency'       => Yii::$app->user->identity->city->country->bill->currency,
    'description'    => 'description text',
    'order_id'       => Yii::$app->user->identity->getId().'_single12345678901234',
    'sandbox'        => 1,
    'result_url'     => Url::to(['/site/index'], true),
    'server_url'     => Url::to(['/api/liqpay-callback'], true),
));
?>

<?= $html;?>