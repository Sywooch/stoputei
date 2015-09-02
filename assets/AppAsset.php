<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/main.scss',
        'css/bootstrap-switch.css'
    ];
    public $js = [
        'js/main.js',
        'js/user-tour.js',
        'js/manager-create-response-tour.js',
        'js/create-hot-tour.js',
        'js/flights.js',
        'js/user-offers.js',
        'js/manager-offers.js',
        'js/manager-hot-tours.js',
        'js/user-hot-tours.js',
        'js/user-favourites.js',
        'js/image-tooltip.js',
        'js/manager-statistics.js',
        'js/profile.js',
        'js/bootstrap-switch.js',
    ];
    public $images = [];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset'
    ];
}
