<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;
use yii\helpers\VarDumper;
use cornernote\gii\helpers\TabPadding;

/**
 * @var yii\web\View $this
 * @var schmunk42\giiant\crud\Generator $generator
 */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ButtonDropdown;
use <?= $generator->indexWidgetType === 'grid' ? "yii\\grid\\GridView" : "yii\\widgets\\ListView" ?>;
use cornernote\returnurl\ReturnUrl;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var <?= ltrim($generator->modelClass, '\\') ?> $model
 * @var <?= ltrim($generator->searchModelClass, '\\') ?> $searchModel
 */

$this->title = <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>;
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass), '-', true) ?>-index">

    <div class="clearfix">

        <p class="pull-left">
            <?= "<?= " ?>Html::a('<span class="fa fa-plus"></span> ' . <?= $generator->generateString('Create') ?> . ' ' . <?= $generator->generateString(Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>, ['create', 'ru' => ReturnUrl::getToken()], ['class' => 'btn btn-success']) ?>
            <?= "<?= " ?>Html::button('<span class="fa fa-search"></span> ' . <?= $generator->generateString('Search') ?> . ' ' . <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, ['class' => 'btn btn-info', 'data-toggle' => 'modal', 'data-target' => '#<?= Inflector::camel2id(StringHelper::basename($generator->modelClass), '-', true) ?>-searchModal']) ?>
        </p>

        <div class="pull-right">
<?php
            $items = [];
            $model = new $generator->modelClass;
            foreach ($generator->getModelRelations($model) AS $relation) {
                // relation dropdown links
                $iconType = ($relation->multiple) ? 'arrow-right' : 'arrow-left';
                if ($generator->isPivotRelation($relation)) {
                    $iconType = 'random';
                }
                $controller = $generator->pathPrefix . Inflector::camel2id(
                        StringHelper::basename($relation->modelClass),
                        '-',
                        true
                    );
                $route = $generator->createRelationRoute($relation,'index');
                $label      = Inflector::titleize(StringHelper::basename($relation->modelClass), '-', true);
                $items[] = [
                    'label' => '<i class="fa fa-' . $iconType . '"></i> ' . $label,
                    'url'   => [$route]
                ];
            }
            ?>

            <?= "<?=\n" ?>
            ButtonDropdown::widget([
                'id' => 'giiant-relations',
                'encodeLabel' => false,
                'label' => '<span class="fa fa-paperclip"></span> ' . <?= $generator->generateString('Relations') ?>,
                'dropdown' => [
                    'options' => [
                        'class' => 'dropdown-menu-right'
                    ],
                    'encodeLabels' => false,
                    'items' => <?= TabPadding::pad(VarDumper::export($items), 5) ?>,
                ],
            ]);
            <?= "?>" ?>


        </div>

    </div>

    <?= "<?php " . ($generator->indexWidgetType === 'grid' ? '' : '') ?>echo $this->render('_search', ['model' => $searchModel]); ?>

<?php if ($generator->indexWidgetType === 'grid'): ?>
    <div class="table-responsive">
        <?= "<?= " ?>GridView::widget([
            'layout' => '{summary}{pager}{items}{pager}',
            'dataProvider' => $dataProvider,
            'pager' => [
                'class' => yii\widgets\LinkPager::className(),
                'firstPageLabel' => <?= $generator->generateString('First') ?>,
                'lastPageLabel' => <?= $generator->generateString('Last') ?>,
            ],
            'filterModel' => $searchModel,
            'columns' => [
<?php
        $class = $generator->modelClass;
        $actionButtonColumn = <<<PHP
                [
                    'class' => '{$generator->actionButtonClass}',
                    'urlCreator' => function (\$action, \$model, \$key, \$index) {
                        // using the column name as key, not mapping to 'id' like the standard generator
                        \$params = is_array(\$key) ? \$key : [\$model->primaryKey()[0] => (string)\$key];
                        \$params[0] = Yii::\$app->controller->id ? Yii::\$app->controller->id . '/' . \$action : \$action;
                        \$params['ru'] = ReturnUrl::getToken();
                        return Url::toRoute(\$params);
                    },
                    'contentOptions' => ['nowrap' => 'nowrap']
                ],
PHP;

        // action buttons first
        echo $actionButtonColumn;

        $count = 0;
        echo "\n"; // code-formatting

        foreach ($generator->getTableSchema()->columns as $column) {
            $format = $generator->columnFormat($column->name,$model);
            if ($format == false) continue;
            $format = (++$count < 10) ? "{$format},\n" : "        /*" . trim($format) . "*/\n";
            echo TabPadding::pad($format, 2, true);
        }

        ?>
            ],
        ]); ?>
    </div>

<?php else: ?>
        <?= "<?= " ?> ListView::widget([
            'dataProvider' => $dataProvider,
            'itemOptions' => ['class' => 'item'],
            'itemView' => function ($model, $key, $index, $widget) {
                return Html::a(Html::encode($model-><?= $nameAttribute ?>), ['view', <?= $urlParams ?>]);
            },
        ]); ?>

<?php endif; ?>
</div>