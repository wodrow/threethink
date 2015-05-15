<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用入口文件

// 检测PHP环境
ini_set("display_errors", "On");
error_reporting(E_ALL | E_STRICT);
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');
// $dbhost = '192.168.0.15';
// $username = 'root';
// $userpass = 'root';
// $dbname = 'threethink';
//  //生成一个连接
//  $db_connect=mysql_connect($dbhost,$username,$userpass) or die("Unable to connect to the MySQL!");

//  //选择一个需要操作的数据库
//  mysql_select_db($dbname,$db_connect);
 
//  //执行MySQL语句
//  $result=mysql_query("SELECT * FROM tt_config");
 
//  //提取数据
//  $row=mysql_fetch_row($result);
//  var_dump($row);
// exit('x');

// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG',True);

// define('BIND_MODULE','Admin');

// 定义应用目录
define('APP_PATH','./Application/');

/**
 * 缓存目录设置
 * 此目录必须可写，建议移动到非WEB目录
 */
define ( 'RUNTIME_PATH', './Runtime/' );

// 引入ThinkPHP入口文件
require './ThinkPHP/ThinkPHP.php';

// 亲^_^ 后面不需要任何代码了 就是如此简单