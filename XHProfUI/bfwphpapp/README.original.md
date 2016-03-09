BFWPHP_APP
==========

感谢@baojunbo 欢迎联系作者：baojunbo@gmail.com
以下说明转自https://github.com/baojunbo/BFWPHP

BFWPHP
======
BFWPHP是一款轻型，灵巧的PHP开发框架，适合中小型项目开发。其基础类库主要封装了PDO，Redis，Memcache，文件处理，日志处理等类，实现了项目中目录及类的自动化寻找，以方便项目的开发维护。BFWPHP也采用MVC的设计思想，但又有别于传统的MVC设计。BFWPHP中的C是controller(控制器)，它控制调度M和V，M是模块层开发自己写class文件，V是显示层主要是HTML格式和JSON格式的文本。M层和V层的类文件都会被放到项目的class目录（HTML格式的模板文件除外，开发者可以任意放在一个可读的目录）。


Table of contents
=================
1. [项目主文件代码](#项目主文件代码)
2. [创建新项目、类、DAO](#创建新项目、类、dao)
 * [创建新项目](#创建新项目)
 * [创建类](#创建类)
 * [创建DAO](#创建dao)
 * [创建Daemon](#创建daemon)
3. [项目目录结构](#项目目录结构)
4. [基础类及方法说明](#基础类及方法说明)
 * [BFW_App](#bfw_app)
 * [BFW_Autoload](#bfw_autoload)
 * [BFW_Config](#bfw_config)
 * [BFW_Controller](#bfw_controller)
 * [BFW_Curl](#bfw_curl)
 * [BFW_Daemon](#bfw_daemon)
 * [BFW_Debug](#bfw_debug)
 * [BFW_Error](#bfw_error)
 * [BFW_File](#bfw_file)
 * [BFW_Log](#bfw_log)
 * [BFW_Memcache](#bfw_memcache)
 * [BFW_Mysql](#bfw_mysql)
 * [BFW_MysqlPage](#bfw_mysqlpage)
 * [BFW_Obj](#bfw_obj)
 * [BFW_Redis](#bfw_redis)
 * [BFW_Request](#bfw_request)
 * [BFW_View](#bfw_view)

项目主文件代码
================
项目入口主文件app.php，BFWPHP建议一个项目只有一个入口。这样简单，明了。
``` php
<?php
$dirName = __DIR__;
define('PATH_LIB', "/Users/baojunbo/workspace/bfw/lib");
define('PATH_CONFIG', "{$dirName}/config");
define('PATH_CLASS', "{$dirName}/class");
define('PATH_INCLUDE', "{$dirName}/include");
define('PATH_LOG', "{$dirName}/log");//NOTE:此处注意要保证此目录有其他用户写权限，推荐目录/var/www/log

require_once PATH_LIB . '/autoload.php';

$app = new BFW_App('target');
$app->setUserError();
$app->setDebug();
$app->run();
```
浏览器访问

`http://localhost/app.php?target=Obj_User.getInfo&uid=1`

命令行运行

`php app.php Obj_User.getInfo 1`

创建新项目、类、DAO
================
下面的内容简单介绍了利用BFWPHP创建一个新项目，以及在项目中创建类文件和DAO。
创建新项目
---------
``` shell
php bfw/bfw.php createProject projectName
```

创建类
-----
``` shell
" 创建Obj类
php bfw/bfw.php newClass Obj projectName

" 创建Obj_User类
php bfw/bfw.php newClass Obj_User projectName
```

创建DAO
-------
DAO(Data Access Object)，数据访问对象。主要负责与数据库进行数据读写操作。Mysql以表作为dao来命名DAO，Redis和Mc则以相对应的服务器来命名。
``` shell
" 创建Mysql数据库的user表DAO
php bfw/bfw.php newDao Dao_Mysql_User projectName

" 创建Redis A服务器DAO
php bfw/bfw.php newDao Dao_Redis_ServerA projectName

" 创建MC A服务器DAO
php bfw/bfw.php newDao Dao_Mc_ServerA projectName
```

创建Daemon
----------
支持简单的守护进程。PHP版本尽量是最新的，否则守护进程吃内存比较严重。样例如下：
``` shell
" 创建Daemon
php bfw/bfw.php newDaemon user projectName

" 运行Daemon
php projectName/calss/daemon/user.php start

" 停止Daemon
php projectName/calss/daemon/user.php stop

" 重启Daemon
php projectName/calss/daemon/user.php restart
```

项目目录结构
===========
``` php
| // 项目根目录
|___app.php // 入口主文件
|___class // 项目类
	|___Obj // 项目对象类
	|___Mod // 项目业务类
	|___Dao // 数据访问对象类
		|___Mysql // Mysql
		|___Redis // Redis
		|___Mc // Memcache
|___config // 配置文件目录
|___include // 第三方类库
|___tpl // 模板目录
|___log // 日志目录
|___data // 数据文件目录
```

基础类及方法说明
==============

BFW_App
-------
**描述：**项目主文件类 [lib/app.php](lib/app.php) 见：[项目主文件代码](#项目主文件代码)
``` php
<?php
$app = new BFW_App('target');
$app->setUserError();
$app->setDebug();
$app->run();
```
**公共方法**
* BFW_App::__construct($target = null)
 - **$target** 定义接收类名及方法变量名称
* BFW_App::run()
* BFW_App::setUserError($userError = true)
 - **$userError** 是否启用自定义PHP运行过程错误信息收集程序 true: 启用 false: 不启用
* BFW_App::setDebug($onOff = true)
 - **$onOff** 是否开启debug模式 true: 开启 false: 关闭
* BFW_App::__destruct()

BFW_Autoload
------------
**描述：**基础类，项目类自动加载类 [lib/autoload.php](lib/autoload.php) 只需要包含即可。见[项目主文件代码](#项目主文件代码)
``` php
require_once 'lib/autoload.php';
```

BFW_Config
----------
**描述：**配置信息类 [config.php](lib/config.php)
``` php
<?php
// 获取配置文件所有数据
$users = BFW_Config::get('users');

// 获取配置文件下某个项的数据
$baojunbo     = BFW_Config::get('users.baojunbo');
$baojunboName = BFW_Config::get('users.baojunbo.name');
```
**公共方法**
* BFW_Config::get($key, $default = null)
 - **$key** 以"."分隔的层级关系，最开始一个表示配置文件名

BFW_Controller
--------------
**描述：**控制器类 [lib/controller.php](lib/controller.php)，负责控制调度项目中类方法。
``` php
<?php
$userInfo = BFW_Controller::get('mod_user.getInfo', 1);
```
**公共方法**
 * BFW_Controller::get($classMethod)
  - **$classMethod** 类方法名，以"."拼接，"."之前的是类名，之后的方法名。如果没有"."方法名默认为run 如：user.getInfo | user

BFW_Curl
--------
**描述：**封装curl扩展类 [lib/curl.php](lib/curl.php)
``` php
<?php
// 调用单个URL
BFW_Curl::setData(array('id' => 1, 'name' => 'baojunbo'), "GET");
BFW_Curl::setOption(CURLOPT_RETURNTRANSFER, false);
BFW_Curl::setCookie('key', 'value');
BFW_Curl::setUserPass('user', 'password');
$content = BFW_Curl::call('http://www.xxx.com/xxx/xx.php', 1);

// 调用用多个URL
$urls = array(
	'sina' => array(
		'url' => 'http://www.sina.com.cn',
		'method' => 'GET',
	),
	'baidu' => array(
		'url' => 'http://www.baidu.com',
		'method' => 'POST',
	),
	'google' => array(
		'url' => 'http://www.google.com',
		'method' => 'GET',
		'data' => array('q' => 'hello world'),
	)
);
$contents = BFW_Curl::call($urls, 0.1);
```
**公共方法**
 * BFW_Curl::setData($data, $method = 'GET')
  - **$data** 调用url接收的数据 如：`array('id' => 1, 'name' => 'baojunbo')`
  - **$method** 传递数据的方法 GET或POST 默认GET
 * BFW_Curl::setOption($key, $val = null)
  - **$key** 参数名（cUrl常量 如：CURLOPT_RETURNTRANSFER等），该参数可以数组的形式。如：`array(CURLOPT_RETURNTRANSFER => true, CURLOPT_FOLLOWLOCATION => true)`
  - **$val** 参数值
 * BFW_Curl::setCookie($key, $val)
   - **$key** cookie名
   - **$val** cookie值
 * BFW_Curl::setUserPass($user, $pass)
   - **$user** 用户名
   - **$pass** 用户密码
 * BFW_Curl::call($urls, $timeout = 1, $header = array())
   - **$urls** 被调用的url，也可以是urls数组。详情见样列代码
   - **$timeout** 超时时间 默认1秒
   - **$header** http header头

BFW_Debug
---------
**描述：**调试类 [lib/debug.php](lib/debug.php)
``` php
<?php
$debugKey = 'debug';
BFW_Debug::start($debug);
// your code
BFW_Debug::setDebugInfo($debug, 'infoKey', 'infoVal');
BFW_Debug::end($debug);

// 将调试信息写入文件，在程序结束时调用
BFW_Debug::writeDebugInfo();
```
**公共方法**
 * BFW_Debug::start($key)
  - **$key** 调试点关键字
 * BFW_Debug::end($key)
  - **$key** 调试点关键字
 * BFW_Debug::setDebugInfo($key,  $infoKey, $infoData)
  - **$key** 调试点关键字
  - **$infoKey** 详细调试信息关键字
  - **$infoData** 详细调试信息
 * BFW_Debug::writeDebugInfo()

BFW_Error
---------
**描述：**自定义错误收集类 [lib/error.php](lib/error.php)
``` php
<?php
// 设置自定义错误收集方法，在程序开始时设置
set_error_handler(array('BFW_Error', 'setError'));
```
**公共方法**
 * BFW_Error::setError($errNo, $errMsg, $fileName, $lineNum, $vars)
  - **$errNo** 错误代码
  - **$errMsg** 错误信息
  - **$fileName** 文件名
  - **$lineNum** 行号
  - **$vars** 变量

BFW_File
--------
**描述：**文件类 [lib/file.php](lib/file.php)
``` php
<?php
BFW_File::write('/user/home/baojunbo/tmp/error/20141011.log', 'content' 'a');
```
**公共方法**
 * BFW_File::write($file, $content, $type = 'w')
  - **$file** 文件名
  - **$content** 内容
  - **$type** 内容写入方式 w: 擦除写入 a: 追加写入

BFW_Log
-------
**描述：**日志类 [lib/log.php](lib/log.php)
``` php
<?php
BFW_Log::error('error log'); // error
BFW_Log::notice('notice log'); // notice
BFW_Log::warning('warning log'); // warning
BFW_Log::fatal('fatal log'); // fatal
BFW_Log::debug('debug log'); // debug

// 写入日志，在程序结束时调用
BFW_Log::write();
```
**公共方法**
 * BFW_Log::error($log)
 * BFW_Log::notice($log)
 * BFW_Log::warning($log)
 * BFW_Log::fatal($log)
 * BFW_Log::debug($log)
 * BFW_Log::write()

BFW_Memcache
------------
**描述：**Memcache类 [lib/memcache.php](lib/memcache.php) 被Dao_Mc类继承，提供memcached扩展的所有方法，并新增mget方法
``` php
<?php
$mcDao = Dao_Mc_McServer::getInstance();

// 取单个key
$userInfo = $mcDao->get('uid:10001');

// 取多个key
$usersInfo = $mcDao->mget(array('uid:10000', 'uid:10001'));
```

BFW_Mysql
---------
**描述：**Mysql类 [lib/mysql.php](lib/mysql.php) 被Dao_Mysql类继承。
``` php
<?php
$mysqlDao = Dao_Mysql_User::getInstance();
$mysqlDao->setDBName("$dbName");
$mysqlDao->setTableName("{$dbName}.{$tableName}");
$mysqlDao->setTablePrimaryKey("$keyName");

// 取一行数据
$userInfo = $mysqlDao->get("uid = :id", "*", array(':id' => 1));

// 取多行数据
$usersInfo = $mysqlDao->mget("uid < :id", "*", array(':id' => 10));

// 按分页取数据
$pUsersInfo = $mysqlDao->pget("uid < :id", "*", array(':id' => 100), array('perPage' => 10, 'group' => 10));

// 更新数据
$res = $mysqlDao->set(array('u_name' => '"baojunbo"'), "uid = :id", array(":id" => 1));

// 插入数据
$res = $mysqlDao->set(array('u_name' => '"baojunbo"'));

// 删除数据
$res = $mysqlDao->del("uid = :id", array(":id" => 1));
```
**公共方法**
 * mysqlDao::get($where, $fields = '*', $params = array())
 * mysqlDao::mget($where, $fields = '*', $params = array())
 * mysqlDao::pget($where, $fields = '*', $params = array(), $config = array())
 * mysqlDao::set($data, $where = null, $params = null)
 * mysqlDao::del($where, $params = null)



BFW_MysqlPage
-------------
**描述：**Mysql按分页获取数据类 [lib/mysqlpage.php](lib/mysqlpage.php) 该类方法只提供给BFW_Mysql::pget()调用。
``` php
<?php
return BFW_MysqlPage::get($pdo, $where, $fields, $params, $config);
```
**公共方法**
 * BFW_MysqlPage::get($pdo, $where, $fields, $params, $config)

BFW_Obj
-------
**描述：**抽象对象类，理论上所有类都要继承该类 [lib/obj.php](lib/obj.php)
``` php
<?php
class obj extends BFW_Obj {

}
```
**公共方法**
 * BFW_Obj::__call($method, $params)
 * BFW_Obj::__callStatic($method, $params)

BFW_Redis
---------
**描述：**Redis类 [lib/redis.php](lib/redis.php) 被Dao_Redis类继承，提供原Redis扩展的所有方法，redis方法参考：[PHPRedis](https://github.com/nicolasff/phpredis)
``` php
<?php
$redisDao = Dao_Redis_RedisServer::getInstance();

// string
$value = $redisDao->get('key');
$values= $redisDao->mget(array($key1, $key2));
```

BFW_Request
-----------
**描述：**数据获取类 封装了$_GET，$_POST，$_REQUEST，$_SERVER，$_COOKIE，$_SESSION数据的获取方法
``` php
<?php
// GET相关
$value = BFW_Request::get('key', 1);
$values= BFW_Request::getx('key1', 'key2');

// POST相关
$value = BFW_Request::post('key', 1);
$values= BFW_Request::postx('key1', 'key2');

// REQUEST相关
$value = BFW_Request::request('key', 1);
$values= BFW_Request::requestx('key1', 'key2');

// SERVER相关
$value = BFW_Request::server('key', 1);
$values= BFW_Request::serverx('key1', 'key2');

// COOKIE相关
$value = BFW_Request::cookie('key', 1);
$values= BFW_Request::cookiex('key1', 'key2');

// SESSION相关
$value = BFW_Request::session('key', 1);
$values= BFW_Request::sessionx('key1', 'key2');
```
**公共方法**
 * BFW_Request::get($key, $default = null)
 * BFW_Request::getx()
 * BFW_Request::post($key, $default = null)
 * BFW_Request::postx()
 * BFW_Request::request($key, $default = null)
 * BFW_Request::requestx()
 * BFW_Request::server($key, $default = null)
 * BFW_Request::serverx()
 * BFW_Request::session($key, $default = null)
 * BFW_Request::sessionx()

BFW_View
--------
**描述：**模板类
``` php
<?php
BFW_View::setTplDir('/User/home/baojunbo/tpl'); // 设置模板目录
BFW_View::set('user', 'baojunbo'); // 设置变量

if ($display == 'yes') {
	BFW_View::display('user.php'); // 直接显示模板
} else {
	$tplData = BFW_View::fetch('user.php'); // 以数据形式返回
	echo $tplData;
}
```
**公共方法**
 * BFW_View::setTplDir($tplDir)
 * BFW_View::set($key, $value = null)
 * BFW_View::get($key)
 * BFW_View::display($tpl)
 * BFW_View::fetch($tpl)


