<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/**
 * @var yii\web\View $this
 * @var yii\gii\generators\crud\Generator $generator
 */

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/**
 * @var yii\web\View $this
 * @var <?= ltrim($generator->searchModelClass, '\\') ?> $model
 * @var yii\bootstrap\ActiveForm $form
 */
?>

<div id="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass), '-', true) ?>-searchModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass), '-', true) ?>-searchModalLabel" aria-hidden="true">

    <?= "<?php " ?>$form = ActiveForm::begin([
        'action' => ['index'],
        'layout' => 'horizontal',
        'method' => 'get',
        'fieldConfig' => [
            'horizontalCssClasses' => [
                'offset' => 'col-sm-offset-3',
                'label' => 'col-sm-3',
                'wrapper' => 'col-sm-9',
                'error' => '',
                'hint' => '',
            ],
        ],
    ]); ?>

    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass), '-', true) ?>-searchModalLabel"><?= '<?= ' ?><?= $generator->generateString('Search') ?> . ' ' . <?= $generator->generateString(Inflector::pluralize(StringHelper::basename($generator->modelClass))) ?><?= ' ?>' ?></h4>
            </div>
            <div class="modal-body">
<?php
                foreach ($generator->getTableSchema()->getColumnNames() as $attribute) {
                    echo "                <?= " . $generator->generateActiveSearchField($attribute) . " ?>\n";
                }
                ?>
            </div>
            <div class="modal-footer">
                <?= "<?= " ?>Html::submitButton(<?= $generator->generateString('Search') ?>, ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>

    <?= "<?php " ?>ActiveForm::end(); ?>

</div>
