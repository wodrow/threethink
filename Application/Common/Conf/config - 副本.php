<?php
$x = array(
	
	'WEB_IP' => '192.168.1.12',
	'WEB_DOMAIN_NAME' => 'localhost/threethink',
	'WEB_INDEX' => 'http://localhost/threethink/index.php',
	'WEB_TITLE' => '三思框架',

	'USE_DESCRIPTION' => '这个是一个开源自由的基于thinkPHP和Bootstrap的cmf系统，感谢使用',
	'AUTH_NICKNAME' => 'WODROW',
	'AUTH_EMAIL' => 'wodrow451611cv@gmail.com',

	'MODULE_ALLOW_LIST'  => array('Home','Admin','Common'),
	
	// root用户
	'ROOT_NAME' => 'wodrow',
	'ROOT_EMAIL' => 'wodrow451611cv@gmail.com',
	'ROOT_PASSWORD' => 'b87ff5ef778737fad86cc57f10d129cd',

	// 模板设置
	'DEFAULT_THEME'         =>  'bootstrap_tpl',	// 默认模板主题名称

	// 数据库
	'DB_TYPE'               =>  'mysqli',     // 数据库类型
    'DB_HOST'               =>  'localhost', // 服务器地址
    'DB_NAME'               =>  'threethink',          // 数据库名
    'DB_USER'               =>  'root',      // 用户名
    'DB_PWD'                =>  'root',          // 密码
    'DB_PORT'               =>  '3306',        // 端口
    'DB_PREFIX'             =>  'tt_',    // 数据库表前缀

	// 自定义
	/* 模板相关配置 */
    'TMPL_PARSE_STRING' => array(
    	'__WODROW__' => __ROOT__ . '/Public/wodrow',
    	'__UPLOADS__'=>__ROOT__ . '/Uploads',
        '__STATIC__' => __ROOT__ . '/Public/static',
        '__COMMON__' => __ROOT__ . '/Public/common',
        '__HOME__' =>   __ROOT__ . '/Public/home',
        '__ADMIN__' =>   __ROOT__ . '/Public/admin',
    	'__BOOTSTRAP__' => __ROOT__ . '/Public/static/bootstrap-3.3.2',
    ),
);

return $x;