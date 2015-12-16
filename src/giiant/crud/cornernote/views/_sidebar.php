<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/**
 * @var yii\web\View $this
 * @var schmunk42\giiant\generators\crud\Generator $generator
 */

echo "<?php\n";
?>

use yii\helpers\Url;

/**
 * @var yii\web\View $this
 */

$controller = Yii::$app->controller;
?>

<li class="<?= "<?php " ?>echo $controller->id == '<?= Inflector::camel2id(StringHelper::basename($generator->modelClass), '-', true) ?>' ? 'open active' : '' ?>">
    <a href="#" class="dropdown-toggle">
        <i class="menu-icon fa fa-book"></i>
        <span class="menu-text"><?= Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?></span>
        <b class="arrow fa fa-angle-down"></b>
    </a>

    <b class="arrow"></b>

    <ul class="submenu">
        <li class="<?= "<?= " ?>$controller->id == '<?= Inflector::camel2id(StringHelper::basename($generator->modelClass), '-', true) ?>' && $controller->action->id == 'create' ? 'active' : '' ?>">
            <a href="<?= "<?= " ?>Url::to(['/<?= Inflector::camel2id(StringHelper::basename($generator->modelClass), '-', true) ?>/create']) ?>">
                <i class="menu-icon fa fa-caret-right"></i>
                Create <?= Inflector::camel2words(StringHelper::basename($generator->modelClass)) ?>
            </a>
            <b class="arrow"></b>
        </li>
        <li class="<?= "<?= " ?>$controller->id == '<?= Inflector::camel2id(StringHelper::basename($generator->modelClass), '-', true) ?>' && $controller->action->id == 'index' ? 'active' : '' ?>">
            <a href="<?= "<?= " ?>Url::to(['/<?= Inflector::camel2id(StringHelper::basename($generator->modelClass), '-', true) ?>/index']) ?>">
                <i class="menu-icon fa fa-caret-right"></i>
                List <?= Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>
            </a>
            <b class="arrow"></b>
        </li>
    </ul>
</li>
