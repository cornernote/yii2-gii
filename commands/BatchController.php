<?php
namespace cornernote\giitools\commands;

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

    public $template = 'gii-tools';
    public $overwrite = true;
    public $extendedModels = false;
    public $modelNamespace = 'app\models';
    public $modelBaseClass = 'app\db\ActiveRecord';
    public $crudControllerNamespace = 'app\modules\admin\controllers';
    public $crudSearchModelNamespace = 'app\models\search';
    public $crudViewPath = '@admin/views';
    public $crudPathPrefix = '';
    public $crudProviders = [
        '\cornernote\giitools\giiant\crud\providers\RelationProvider',
        '\cornernote\giitools\giiant\crud\providers\DateTimeProvider',
        '\cornernote\giitools\giiant\crud\providers\CallbackProvider',
        '\cornernote\giitools\giiant\crud\providers\EditorProvider',
    ];

    /**
     * Can be removed when this is merged:
     * https://github.com/schmunk42/yii2-giiant/pull/67
     */
    public $generateQuery = true;
    public $queryNs = 'app\models\query';
    public $queryBaseClass = 'yii\db\ActiveQuery';

    /**
     * Can be removed when this is merged:
     * https://github.com/schmunk42/yii2-giiant/pull/67
     *
     * @inheritdoc
     */
    public function actionModels()
    {
        // create models
        foreach ($this->tables AS $table) {
            #var_dump($this->tableNameMap, $table);exit;
            $params = [
                'interactive' => $this->interactive,
                'overwrite' => $this->overwrite,
                'template' => $this->template,
                'ns' => $this->modelNamespace,
                'db' => $this->modelDb,
                'tableName' => $table,
                'tablePrefix' => $this->tablePrefix,
                'enableI18N' => $this->enableI18N,
                'messageCategory' => $this->messageCategory,
                'generateModelClass' => $this->extendedModels,
                'modelClass' => isset($this->tableNameMap[$table]) ? $this->tableNameMap[$table] :
                    Inflector::camelize($table), // TODO: setting is not recognized in giiant
                'baseClass' => $this->modelBaseClass,
                'tableNameMap' => $this->tableNameMap,
                'generateQuery' => $this->generateQuery,
                'queryNs' => $this->queryNs,
                'queryBaseClass' => $this->queryBaseClass,
            ];
            $route = 'gii/giiant-model';

            $app = \Yii::$app;
            $temp = new \yii\console\Application($this->appConfig);
            $temp->runAction(ltrim($route, '/'), $params);
            unset($temp);
            \Yii::$app = $app;
        }

    }

}