<?php
/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        //'css/ajaxcrud.css',
    ];
    public $js = [
        'https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js',
        //'assets/9b731ec9/js/dialog.js',
        'js/ModalRemote.js',
        'js/ajaxcrud.js',
        //'assets/9b731ec9/js/bootstrap-dialog.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset'
    ];
}
