<?php
/**
 * bootstrap.php
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @link https://mrphp.com.au/
 */

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'test');

require_once(__DIR__ . '/../../vendor/autoload.php');
require_once(__DIR__ . '/../../vendor/yiisoft/yii2/Yii.php');

Yii::setAlias('@tests', __DIR__);

new \yii\console\Application([
    'id' => 'unit',
    'basePath' => __DIR__,
    'modules' => [
        'gii' => [
            'class' => 'yii\gii\Module',
            'allowedIPs' => ['*'],
            'generators' => [
                'giiant-model' => [
                    'class' => 'schmunk42\giiant\generators\model\Generator',
                    'templates' => [
                        'cornernote' => '@vendor/cornernote/yii2-gii/giiant/model/cornernote',
                    ],
                ],
                'giiant-crud' => [
                    'class' => 'schmunk42\giiant\generators\crud\Generator',
                    'templates' => [
                        'cornernote' => '@vendor/cornernote/yii2-gii/giiant/crud/cornernote',
                    ],
                ],
            ],
        ],
    ],
    'controllerMap' => [
        'gii-batch' => 'cornernote\gii\commands\BatchController'
    ],
]);
