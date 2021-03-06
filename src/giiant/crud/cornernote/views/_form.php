<?php

use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;

/**
 * @var yii\web\View $this
 * @var schmunk42\giiant\generators\crud\Generator $generator
 */

/** @var \yii\db\ActiveRecord $model */
$model = new $generator->modelClass;
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->getTableSchema()->columnNames;
}

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use \dmstr\bootstrap\Tabs;
use cornernote\returnurl\ReturnUrl;

/**
 * @var yii\web\View $this
 * @var <?= ltrim($generator->modelClass, '\\') ?> $model
 * @var yii\bootstrap\ActiveForm $form
 */

?>

<div class="<?= \yii\helpers\Inflector::camel2id(StringHelper::basename($generator->modelClass), '-', true) ?>-form">

    <?= "<?php " ?>$form = ActiveForm::begin([
        'id' => '<?= $model->formName() ?>',
        'layout' => '<?= $generator->formLayout ?>',
        'enableClientValidation' => false,
    ]); ?>

    <?= "<?=" ?> Html::hiddenInput('ru', ReturnUrl::getRequestToken()); ?>

    <?= "<?=" ?> $form->errorSummary($model); ?>

    <?php echo "<?php \$this->beginBlock('main'); ?>"; ?>

<?php foreach ($safeAttributes as $attribute) {
        $prepend = $generator->prependActiveField($attribute, $model);
        $field = $generator->activeField($attribute, $model);
        $append = $generator->appendActiveField($attribute, $model);

        if ($prepend) {
            echo "\n    <?php " . $prepend . " ?>";
        }
        if ($field) {
            echo "\n    <?= " . $field . " ?>";
        }
        if ($append) {
            echo "\n    <?php " . $append . " ?>";
        }
        echo "\n";
    } ?>


    <?php echo "<?php \$this->endBlock(); ?>"; ?>

<?php
    $label = substr(strrchr($model::className(), "\\"), 1);;

    $items = <<<EOS
            [
                'label' => '$label',
                'content' => \$this->blocks['main'],
                'active' => true,
            ],
EOS;
        ?>

    <?= "<?= Tabs::widget([
        'encodeLabels' => false,
        'items' => [
$items
        ],
    ]); ?>"; ?>

    <?= "<?= " ?>Html::submitButton('<span class="fa fa-check"></span> ' . ($model->isNewRecord ? <?= $generator->generateString('Create') ?> : <?= $generator->generateString('Save') ?>), [
        'id' => 'save-' . $model->formName(),
        'class' => 'btn btn-success'
    ]); ?>
    <?= "<?php " ?>if($model->isNewRecord) echo Html::a('<span class="fa fa-times"></span> ' . <?= $generator->generateString('Cancel') ?>, ReturnUrl::getUrl(['index']), ['class' => 'btn btn-default']) ?>

    <?= "<?php " ?>ActiveForm::end(); ?>

</div>
