<?php

use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;

/**
 * @var yii\web\View $this
 * @var yii\gii\generators\crud\Generator $generator
 */

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

use yii\helpers\Html;
use cornernote\helpers\ReturnUrl;

/**
 * @var yii\web\View $this
 * @var <?= ltrim($generator->modelClass, '\\') ?> $model
 */

?>

<!-- menu buttons -->
<p class='pull-left'>
    <?= "<?= " ?>Html::a('<span class="fa fa-arrow-left"></span> ' . <?= $generator->generateString('Back') ?>, ReturnUrl::getUrl(['index']), ['class' => 'btn btn-default']) ?>
    <?= "<?= " ?>Html::a('<span class="fa fa-eye"></span> ' . <?= $generator->generateString('View') ?>, ['view', <?= $urlParams ?>, 'ru' => ReturnUrl::getRequestToken()], ['class' => 'btn btn-primary']) ?>
    <?= "<?= " ?>Html::a('<span class="fa fa-pencil"></span> ' . <?= $generator->generateString('Update') ?>, ['update', <?= $urlParams ?>, 'ru' => ReturnUrl::getRequestToken()], ['class' => 'btn btn-info']) ?>
<?php foreach($generator->getScenarios($generator->modelClass) as $scenarioName => $scenario) {
    if (in_array($scenarioName, ['default', 'create', 'update'])) {
        continue;
    }
    ?>
    <?= "<?= " ?>Html::a(<?= $generator->generateString(ucfirst($scenarioName)) ?>, ['<?= $scenarioName ?>', <?= $urlParams ?>, 'ru' => ReturnUrl::getRequestToken()], ['class' => 'btn btn-info']) ?>
<?php } ?>
</p>

<div class="clearfix"></div>