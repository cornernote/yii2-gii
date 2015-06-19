<?php
namespace cornernote\gii\commands;

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
    public $modelBaseClass = 'yii\db\ActiveRecord';
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
     * Can be removed when this is merged:
     * https://github.com/schmunk42/yii2-giiant/pull/67
     */
    public $generateQuery = true;
    public $modelQueryNamespace = 'app\models\query';
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
                'queryNs' => $this->modelQueryNamespace,
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

    /**
     * Can be removed when this is merged:
     * https://github.com/schmunk42/yii2-giiant/pull/69
     *
     * @inheritdoc
     */
    public function actionCruds()
    {
        // create CRUDs
        $providers = ArrayHelper::merge($this->crudProviders, Generator::getCoreProviders());
        foreach ($this->tables AS $table) {
            $table = str_replace($this->tablePrefix, '', $table);
            $name = isset($this->tableNameMap[$table]) ? $this->tableNameMap[$table] : Inflector::camelize($table);
            $params = [
                'interactive' => $this->interactive,
                'overwrite' => $this->overwrite,
                'template' => $this->template,
                'modelClass' => $this->modelNamespace . '\\' . $name,
                'searchModelClass' => $this->crudSearchModelNamespace . '\\' . $name . 'Search',
                'controllerClass' => $this->crudControllerNamespace . '\\' . $name . 'Controller',
                'viewPath' => $this->crudViewPath,
                'pathPrefix' => $this->crudPathPrefix,
                'tablePrefix' => $this->tablePrefix,
                'enableI18N' => $this->enableI18N,
                'messageCategory' => $this->messageCategory,
                'actionButtonClass' => 'yii\\grid\\ActionColumn',
                'baseControllerClass' => $this->crudBaseControllerClass,
                'providerList' => implode(',', $providers),
                'skipRelations' => $this->crudSkipRelations,
            ];
            $route = 'gii/giiant-crud';
            $app = \Yii::$app;
            $temp = new \yii\console\Application($this->appConfig);
            $temp->runAction(ltrim($route, '/'), $params);
            unset($temp);
            \Yii::$app = $app;
        }
    }

}