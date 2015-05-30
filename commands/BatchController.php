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

    public $tables = [];
    public $doModel = true;
    public $doCrud = true;

    public $crudProviders = [
        '\cornernote\giitools\giiant\crud\providers\RelationProvider',
        '\cornernote\giitools\giiant\crud\providers\DateTimeProvider',
        '\cornernote\giitools\giiant\crud\providers\CallbackProvider',
        '\cornernote\giitools\giiant\crud\providers\EditorProvider',
    ];
    public $template = 'gii-tools';
    public $modelNamespace = 'app\models';
    public $interactive = 0;
    public $overwrite = 1;
    public $extendedModels = 0;
    public $crudViewPath = '@admin/views';
    public $crudControllerNamespace = 'app\modules\admin\controllers';
    public $crudSearchModelNamespace = 'app\models\search';
    public $enableI18N = 1;
    public $modelBaseClass = 'app\db\ActiveRecord';
    public $crudPathPrefix = '';

    public $generateQuery = true;
    public $queryNs = 'app\models\query';
    public $queryBaseClass = 'yii\db\ActiveQuery';

    /**
     * @inheritdoc
     */
    public function options($id)
    {
        return array_merge(parent::options($id), [
            'doModel',
            'doCrud',
        ]);
    }

    /**
     * Run batch process to generate models and CRUDs for all given tables
     *
     * @param string $message the message to be echoed.
     */
    public function actionIndex()
    {
        echo "Running batch...\n";

        $config = $this->getYiiConfiguration();
        $config['id'] = 'temp';

        if (!$this->tables) {
            echo "No tables specified.";
            exit;
        }

        // create models
        if ($this->doModel) {
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
                $temp = new \yii\console\Application($config);
                $temp->runAction(ltrim($route, '/'), $params);
                unset($temp);
                \Yii::$app = $app;
            }
        }


        // create CRUDs
        if ($this->doCrud) {
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
                $temp = new \yii\console\Application($config);
                $temp->runAction(ltrim($route, '/'), $params);
                unset($temp);
                \Yii::$app = $app;
            }
        }
    }

}