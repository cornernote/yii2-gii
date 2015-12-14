<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/**
 * @var yii\web\View $this
 * @var schmunk42\giiant\crud\Generator $generator
 */

$urlParams = $generator->generateUrlParams();

/** @var \yii\db\ActiveRecord $model */
$model = new $generator->modelClass;
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->getTableSchema()->columnNames;
}

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use dmstr\bootstrap\Tabs;
use cornernote\returnurl\ReturnUrl;

/**
 * @var yii\web\View $this
 * @var <?= ltrim($generator->modelClass, '\\') ?> $model
 */

$this->title = <?= $generator->generateString(Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?> . ' ' . $model-><?= $generator->getNameAttribute() ?>;
$this->params['heading'] = $model-><?= $generator->getNameAttribute() ?>;
$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->params['heading'];
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass), '-', true) ?>-view">

    <?= '<?= ' ?>$this->render('_menu', compact('model'));<?= ' ?>' ?>

    <?php
    echo "<?php \$this->beginBlock('{$generator->modelClass}'); ?>\n";
    ?>

    <?= "<?= " ?>DetailView::widget([
        'model' => $model,
        'attributes' => [
<?php
foreach ($safeAttributes as $attribute) {
    $format = $generator->attributeFormat($attribute);
    if ($format === false) {
        continue;
    } else {
        echo '            ' . trim($format) . ",\n";
    }
}
?>
        ],
    ]); ?>

    <?= "<?php \$this->endBlock(); ?>"; ?>

<?php
    $label = StringHelper::basename($generator->modelClass);
    $items = <<<EOS
            [
                'label' => '<span class="fa fa-asterisk"></span> $label',
                'content' => \$this->blocks['{$generator->modelClass}'],
                'active' => true,
            ],
EOS;

    foreach ($generator->getModelRelations($generator->modelClass, ['has_many']) as $name => $relation) {

        echo "\n    <?php \$this->beginBlock('$name'); ?>\n";

        // get relation info $ prepare add button
        $model          = new $generator->modelClass;
        $showAllRecords = false;

        if ($relation->via !== null) {
            $pivotName     = Inflector::pluralize($generator->getModelByTableName($relation->via->from[0]));
            $pivotRelation = $model->{'get' . $pivotName}();
            $pivotPk       = key($pivotRelation->link);

            $addButton = "            <?= Html::a(
            '<span class=\"fa fa-link\"></span> ' . " . $generator->generateString('Attach') . " . ' " .
                Inflector::singularize(Inflector::camel2words($name)) .
                "', ['" . $generator->createRelationRoute($pivotRelation, 'create') . "', '" .
                Inflector::singularize($pivotName) . "'=>['" . key(
                    $pivotRelation->link
                ) . "'=>\$model->{$model->primaryKey()[0]}]],
            ['class'=>'btn btn-info btn-xs']
        ) ?>\n";
        } else {
            $addButton = '';
        }

        // relation list, add, create buttons
        echo '    <div class="clearfix">'."\n";
        echo '        <div class="pull-right">'."\n";

        echo "            <?= Html::a(
                '<span class=\"fa fa-list\"></span> ' . " . $generator->generateString('List All') . " . ' " .
                Inflector::camel2words($name) . "',
                ['" . $generator->createRelationRoute($relation, 'index') . "'],
                ['class' => 'btn text-muted btn-xs']
            ) ?>\n";
        // TODO: support multiple PKs, VarDumper?
        echo "            <?= Html::a(
                '<span class=\"fa fa-plus\"></span> ' . " . $generator->generateString('Create') . " . ' " .
                Inflector::singularize(Inflector::camel2words($name)) . "',
                ['" . $generator->createRelationRoute($relation, 'create') . "', '" .
                Inflector::singularize($name) . "' => ['" . key($relation->link) . "' => \$model->" . $model->primaryKey()[0] . "], 'ru' => ReturnUrl::getToken()],
                ['class' => 'btn btn-success btn-xs']
            ); ?>\n";
        echo $addButton;

        echo "        </div>\n";#<div class='clearfix'></div>\n";
        echo "    </div>\n";

        // render pivot grid
        if ($relation->via !== null) {
            $pjaxId       = "pjax-{$pivotName}";
            $gridRelation = $pivotRelation;
            $gridName     = $pivotName;
        } else {
            $pjaxId       = "pjax-{$name}";
            $gridRelation = $relation;
            $gridName     = $name;
        }

        $output = $generator->relationGrid($gridName, $gridRelation, $showAllRecords);

        // render relation grid
        if (!empty($output)):
            echo "    <?php Pjax::begin(['id' => 'pjax-{$name}', 'enableReplaceState' => false, 'linkSelector' => '#pjax-{$name} ul.pagination a, th a', 'clientOptions' => ['pjax:success' => 'function(){alert(\"yo\")}']]) ?>\n";
            echo "    <?= " . $output . "?>\n";
            echo "    <?php Pjax::end() ?>\n";
        endif;

        echo "    <?php \$this->endBlock() ?>\n\n";

        // build tab items
        $label = Inflector::camel2words($name);
        $items .= <<<EOS

            [
                'label' => '<small><span class="fa fa-paperclip"></span> $label</small>',
                'content' => \$this->blocks['$name'],
                'active' => false,
            ],
EOS;
    }
    ?>

    <?=
    // render tabs
    "<?= Tabs::widget([
        'id' => 'relation-tabs',
        'encodeLabels' => false,
        'items' => [
$items
        ]
    ]);
    ?>";
?>


</div>
