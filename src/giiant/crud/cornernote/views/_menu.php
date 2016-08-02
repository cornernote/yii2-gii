<?php

use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;

/**
 * @var yii\web\View $this
 * @var schmunk42\giiant\generators\crud\Generator $generator
 */

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

use yii\helpers\Html;
use cornernote\returnurl\ReturnUrl;

/**
 * @var yii\web\View $this
 * @var <?= ltrim($generator->modelClass, '\\') ?> $model
 */

?>

<!-- menu buttons -->
<p class='pull-left'>
    <?= "<?= " ?>Html::a('<span class="fa fa-arrow-left"></span> ' . <?= $generator->generateString('Back') ?>, ReturnUrl::getUrl(['index']), ['class' => 'btn btn-default']) ?>
    <?= "<?php " ?>if (Yii::$app->controller->action->id != 'view') { <?= "?>\n" ?>
        <?= "<?= " ?>Html::a('<span class="fa fa-eye"></span> ' . <?= $generator->generateString('View') ?>, ['view', <?= $urlParams ?>, 'ru' => ReturnUrl::getRequestToken()], ['class' => 'btn btn-primary']) ?>
    <?= "<?php } ?>\n" ?>
<?php foreach((new $generator->modelClass)->scenarios() as $scenarioName => $scenario) {
    if (in_array($scenarioName, ['default', 'create', 'update'])) {
        continue;
    }
    ?>
    <?= "<?= " ?>Html::a(<?= $generator->generateString(ucfirst($scenarioName)) ?>, ['<?= $scenarioName ?>', <?= $urlParams ?>, 'ru' => ReturnUrl::getRequestToken()], ['class' => 'btn btn-warning']) ?>
<?php } ?>
    <?= "<?php " ?>if (Yii::$app->controller->action->id != 'update') { <?= "?>\n" ?>
        <?= "<?= " ?>Html::a('<span class="fa fa-pencil"></span> ' . <?= $generator->generateString('Update') ?>, ['update', <?= $urlParams ?>, 'ru' => ReturnUrl::getRequestToken()], ['class' => 'btn btn-info']) ?>
    <?= "<?php } ?>\n" ?>
    <?= "<?= " ?>Html::a('<span class="fa fa-trash"></span> ' . <?= $generator->generateString('Delete') ?>, ['delete', <?= $urlParams ?>, 'ru' => ReturnUrl::getRequestToken()], [
    'class' => 'btn btn-danger',
    'data-confirm' => '' . <?= $generator->generateString('Are you sure?') ?> . '',
    'data-method' => 'post',
    ]); ?>
</p>

<div class="clearfix"></div>