<?php
return array(
	//'配置项'=>'配置值'
    // 显示页面Trace信息
    'SHOW_PAGE_TRACE' =>false,

    'UPLOAD_SITEIMG_QINIU' => array (
        'maxSize' => 1 * 1024 * 1024 * 1024 * 1024,//文件大小
        'rootPath' => './',
        'saveName' => array ('uniqid', ''),
        'driver' => 'Qiniu',
        'driverConfig' => array (
            'secrectKey' => '',
            'accessKey' => '',
            'domain' => '',
            'bucket' => '',
        )
    ),

    'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_HOST'   => 'localhost', // 服务器地址
    'DB_NAME'   => '', // 数据库名
    'DB_USER'   => '', // 用户名
    'DB_PWD'    => '', // 密码
    'DB_PORT'   => 3306, // 端口
    'DB_PREFIX' => '', // 数据库表前缀
    'DB_CHARSET'=> 'utf8',// 字符集

);