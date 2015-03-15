祺果视频

1、配置文件在Application/Common/conf/config.php文件中。
    
    （1）七牛配置
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
    
    （2）数据库配置
        'DB_TYPE'   => 'mysql', // 数据库类型
        'DB_HOST'   => 'localhost', // 服务器地址
        'DB_NAME'   => '', // 数据库名
        'DB_USER'   => '', // 用户名
        'DB_PWD'    => '', // 密码
        'DB_PORT'   => 3306, // 端口
        'DB_PREFIX' => '', // 数据库表前缀
        'DB_CHARSET'=> 'utf8',// 字符集

2、数据库文件
    在Database文件下的qiguo.sql;
    
3、关于使用

    （1）git上的项目无数据，需要自己导入数据。
    （2）使用的时候请先导入数据库，然后配置好项目配置文件。
    （3）然后将项目上传到你的web服务根目录。
    （4）项目后台登陆：index.php/Root/User/login


Author ：吴斌

QQ：1215773109

/*********************************/

1、其他遵循开源协议。

2、禁止一切组织和个人未经允许利用或基于本项目进行的一切商业或非商业活动。
