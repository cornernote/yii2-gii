<?php

namespace cornernote\gii;

use yii\base\Application;
use yii\base\BootstrapInterface;


/**
 * Class Bootstrap
 */
class Bootstrap implements BootstrapInterface
{

    /**
     * Bootstrap method to be called during application bootstrap stage.
     *
     * @param Application $app the application currently running
     */
    public function bootstrap($app)
    {
        //if ($app->hasModule('gii')) {
        //    if ($app instanceof \yii\console\Application) {
        //        $app->controllerMap['gii-batch'] = 'cornernote\gii\commands\BatchController';
        //    }
        //}
    }
}
