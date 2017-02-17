<?php

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| First we need to get an application instance. This creates an instance
| of the application / container and bootstraps the application so it
| is ready to receive HTTP / Console requests from the environment.
|
*/

xhprof_enable();
define('__ROOT__', __DIR__);
$app = require __DIR__.'/../bootstrap/app.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request
| through the kernel, and send the associated response back to
| the client's browser allowing them to enjoy the creative
| and wonderful application we have prepared for them.
|
*/

/**
 * @node_name xhprof检测结束，并生成分析文件
 * @param string $output_dir    输出文件保存路径
 * @param string $visit_domain  访问url主域名
 */
function handler_xhprof_end($output_dir = '', $visit_domain = 'xhprof.vm'){
    try{
        $XHPROF_ROOT = !empty($output_dir) ? $output_dir : "/usr/local/src/xhprof-0.9.4";

        $xhprof_data = xhprof_disable();
        include_once $XHPROF_ROOT . "/xhprof_lib/utils/xhprof_lib.php";
        include_once $XHPROF_ROOT . "/xhprof_lib/utils/xhprof_runs.php";

        $xhprof_runs = new \XHProfRuns_Default();

        $run_id = $xhprof_runs->save_run($xhprof_data, "xhprof_foo");

//		echo "\n". "http://{$visit_domain}/index.php?run=$run_id&source=xhprof_foo\n". "\n";
    }catch(\Exception $e){
        var_dump(__FUNCTION__);
        var_dump($e->getMessage());
    }
}
$app->run();
handler_xhprof_end();
