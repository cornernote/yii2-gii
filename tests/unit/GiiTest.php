<?php
/**
 * GiiTest.php
 *
 * @author Brett O'Donnell <cornernote@gmail.com>
 * @link https://mrphp.com.au/
 */

namespace tests;

use tests\models\Post;
use tests\models\Tag;
use Yii;
use yii\console\Application;

/**
 * GiiTest
 */
class GiiTest extends DatabaseTestCase
{

    /**
     * Gii
     */
    public function testGii()
    {
        Yii::$app->runAction('gii-batch', []);
    }
}