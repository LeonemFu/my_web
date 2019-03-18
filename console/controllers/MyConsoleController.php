<?php
/**
 * Created by
 * User: herunfu
 * Date: 2019-01-01
 * 测试控制台模式
 */

namespace console\controllers;

use yii\console\Controller;

class MyConsoleController extends Controller
{
    public function actionTest($say)
    {
        echo 'This is a test of Yii console' . "\n";

        if ($say) {
            var_dump($say);
        }
    }
}
