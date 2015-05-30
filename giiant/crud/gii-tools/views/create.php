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
use yii\helpers\Url;
use cornernote\helpers\ReturnUrl;

/**
 * @var yii\web\View $this
 * @var <?= ltrim($generator->modelClass, '\\') ?> $model
 */

$this->title = <?= $generator->generateString('Create ' . Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>;
$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass), '-', true) ?>-create">

    <p class="pull-left">
        <?= "<?= " ?>Html::a('<span class="fa fa-arrow-left"></span> ' . <?= $generator->generateString('Back') ?>, ReturnUrl::getUrl(['index']), ['class' => 'btn btn-default']) ?>
    </p>

    <div class="clearfix"></div>

    <?= "<?= " ?>$this->render('_form', [
        'model' => $model,
    ]); ?>

</div>
