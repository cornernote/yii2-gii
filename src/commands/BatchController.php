<?php
namespace cornernote\gii\commands;

use yii\console\Application;
use yii\helpers\ArrayHelper;
use schmunk42\giiant\crud\Generator;
use yii\helpers\Inflector;

/**
 * Batch Controller
 *
 * @package app\commands
 */
class BatchController extends \schmunk42\giiant\commands\BatchController
{

    public $interactive = 0;

    public $template = 'cornernote';
    public $overwrite = true;
    public $modelNamespace = 'app\models';
    public $crudControllerNamespace = 'app\modules\admin\controllers';
    public $crudSearchModelNamespace = 'app\models\search';
    public $crudViewPath = '@admin/views';
    public $crudPathPrefix = '';
    public $crudProviders = [
        '\cornernote\gii\giiant\crud\providers\RelationProvider',
        '\cornernote\gii\giiant\crud\providers\DateProvider',
        '\cornernote\gii\giiant\crud\providers\DateTimeProvider',
        '\cornernote\gii\giiant\crud\providers\CallbackProvider',
        '\cornernote\gii\giiant\crud\providers\EditorProvider',
    ];

    /**
     * @return array
     */
    protected function getYiiConfiguration()
    {
        if (YII_ENV == 'test') {
            return [
                'basePath' => \Yii::getAlias('@tests'),
            ];
        }
        return parent::getYiiConfiguration();
    }

}