<?php
session_start();
define('APPLICATION_PATH', dirname(__FILE__));
$application = new Yaf_Application( APPLICATION_PATH . "/conf/application.ini");
$application->bootstrap()->run();
//$application->run();//可以选用是否调用bootstrap，调用采用上面的方法，不加载采用本行方法