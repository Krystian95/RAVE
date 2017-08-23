<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */
namespace app\assets;

use yii\web\AssetBundle;

class AnnotatorAsset extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/annotator/annotator.css',
        'css/annotator/style.css',
        'css/annotator/annotator.touch.css',
        'css/annotator/custom.css'
    ];
    public $js = [
        'js/annotator/annotator-full-custom.js',
        'js/annotator/jquery.i18n.min.js',
        'js/annotator/jquery.dateFormat.js',
        'js/annotator/jquery.slimscroll.js',
        'js/annotator/lunr.min.js',
        'js/annotator/annotator.js',
        'js/annotator/annotator.touch.js',
        'js/annotator/view_annotator.js',
        'js/annotator/categories.js',
        'js/annotator/search.js',
        'js/annotator/annotatorLoader.js',
        'js/annotator/AjaxCaller.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}
