<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */
namespace app\assets;

use yii\web\AssetBundle;

class GoogleMapsAsset extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/google_maps.css'
    ];
    public $js = [
        'https://maps.googleapis.com/maps/api/js?libraries=places&sensor=true&key=AIzaSyAy9WVj2-ghraoUb-lmkp7HcP6QLBwhEiY&language=en',
        'https://www.google.com/jsapi',
        'js/googleMapsLoader.js?ver=2',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}
