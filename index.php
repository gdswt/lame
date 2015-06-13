<?php
/**
 * Lamb - A PHP Framework For my children
 *
 * @package  Lame
 * @author   congli huang <1064344315@qq.com>
 */
/*
|--------------------------------------------------------------------------
| application 预定义文件
|--------------------------------------------------------------------------
|
| application 预定义
|
*/
require(__DIR__.'/application/config/define.php');

/*
|--------------------------------------------------------------------------
| application 配置文件
|--------------------------------------------------------------------------
|
| application配置文件是整个框架的总配置文件，里面的配置主要分两类: 一种是自定义加载那些配置文件;另一种是框架
| 启动时默认的类
|
*/
require(APPLICATION.'/config/application.php');
/*
|--------------------------------------------------------------------------
| application 类定义文件
|--------------------------------------------------------------------------
|
| application 类定义
|
*/
require(SYS_CORE_PATH.'/lamb.php');
/*
|--------------------------------------------------------------------------
| 框架启动时自动注册默认的类文件
|--------------------------------------------------------------------------
|
| 框架启动时自动注册默认的类
|
*/
require(APPLICATION.'/bootstrap/start.php');

/*
|--------------------------------------------------------------------------
| application 运行方法
|--------------------------------------------------------------------------
|
| application 引擎运行入口，听,那引擎"隆隆"的响声
|
*/
Application::run();
?>