<?php
/**
 * BFW Tool
 * @author baojunbo <baojunbo@gmail.com>
 */

class BFW {
	public static function createProject($argv) {
		if (!$argv) throw new Exception("Lost params! USE: php bfw.php createProject projectPath\n", 10001);
		if (is_dir($argv[2])) throw new Exception("{$argv[2]} is exists!\n", 10002);
		
		date_default_timezone_set('UTC');
		
		$projectPath = $argv[2];
		if (!is_dir($projectPath)) {
			mkdir($projectPath, 0755, true);
			mkdir("{$projectPath}/class");
			mkdir("{$projectPath}/config");
			mkdir("{$projectPath}/include");

			$dir = __DIR__;
            $dirSeparator = DIRECTORY_SEPARATOR;
			$dateTime = date("Y-m-d H:i:s");
			$fileContent = "<?php\n";
			$fileContent .= "/**\n";
			$fileContent .= " * here is introduce\n";
			$fileContent .= " * @date	{$dateTime}\n";
			$fileContent .= " */\n\n";
			$fileContent .= "\$dir = __DIR__;\n";
			$fileContent .= "\$libDir = dirname(__DIR__);\n";
			$fileContent .= "define('PATH_LIB', \"{\$libDir}{$dirSeparator}lib\");\n";
			$fileContent .= "define('PATH_CONFIG', \"{\$dir}{$dirSeparator}config\");\n";
			$fileContent .= "define('PATH_CLASS', \"{\$dir}{$dirSeparator}class\");\n";
			$fileContent .= "define('PATH_INCLUDE', \"{\$dir}{$dirSeparator}include\");\n";
			$fileContent .= "define('PATH_LOG', \"{\$dir}{$dirSeparator}log\");//保证此目录有其他用户写入权限\n\n";
			$fileContent .= "require_once PATH_LIB . '{$dirSeparator}autoload.php';\n\n";
			$fileContent .= "\$app = new BFW_App;\n";
			$fileContent .= "\$app->setUserError(); // 使用自定义错误类收集错误信息\n";
            $fileContent .= "\$app->setDebug(); // // 开启调试\n";
			$fileContent .= "\$app->run();\n";

			BFW_File::write("{$projectPath}{$dirSeparator}app.php", $fileContent);
			echo "{$projectPath} is createProject cuscess!\n";
		}
    }

    public static function newClass($argv) {
    	if (!$argv) throw new Exception("Lost params! USE: php bfw.php newClass className projectPath\n", 10003);
    	if (empty($argv[2])) throw new Exception("Lost param className!\n", 10004);
    	if (empty($argv[3])) throw new Exception("Lost param projectPath!\n", 10005);
    	if (!is_dir($argv[3])) throw new Exception("projectPath {$argv[3]} is not exists!\n", 10006);

		date_default_timezone_set('UTC');

    	$className = &$argv[2];
    	$classPath = &$argv[3];
        $classPath .= DIRECTORY_SEPARATOR . "class";

    	$extend = 'BFW_Obj';
    	$dirSeparator = DIRECTORY_SEPARATOR;
    	$position = strrpos($className, '_');
    	if ($position) {
    		$extend = substr($className, 0, $position);
    		$extendFile = $classPath . $dirSeparator . self::_getClassFile($extend, $dirSeparator);
    		if ($extend != "Lib_Obj" && !file_exists("{$extendFile}")) throw new Exception("father class [{$extend}] is not exists!\n", 10007);
    	}
    	$classFile = $classPath . $dirSeparator . self::_getClassFile($className, $dirSeparator);
    	if (file_exists($classFile)) throw new Exception("class [{$className}] is exists!\n", 10008);

    	$dateTime = date("Y-m-d H:i:s");
    	$extends = "extends {$extend}";
    	$fileContent = "<?php\n";
    	$fileContent .= "/**\n";
    	$fileContent .= " * here is introduce\n";
    	$fileContent .= " * @author	yourname <yourname@mail.com>\n";
    	$fileContent .= " * @date	{$dateTime}\n";
    	$fileContent .= " */\n";
    	$fileContent .= "class {$className} {$extends} {\n";
    	if ($extend != "BFW_Obj") {
    		$fileContent .= "\tpublic function run() {\n";
    		$fileContent .= "\t\techo __METHOD__;\n";
    		$fileContent .= "\t}\n";
    	}
    	$fileContent .= "}";

    	BFW_File::write($classFile, $fileContent);

    	echo "class {$className} create sucess!\n";
    }

    public static function newDao($argv) {
        if (!$argv) throw new Exception("Lost params! USE: php bfw.php newDao daoName projectPath\n", 10009);
        if (empty($argv[2])) throw new Exception("Lost param daoName!\n", 10010);
        if (empty($argv[3])) throw new Exception("Lost param projectPath!\n", 10011);
        if (!is_dir($argv[3])) throw new Exception("projectPath {$argv[3]} is not exists!\n", 10012);

		date_default_timezone_set('UTC');

        $dirSeparator = DIRECTORY_SEPARATOR;
        $daoName = &$argv[2];
        $classPath = &$argv[3];
        $classPath .= "{$dirSeparator}class{$dirSeparator}";

        $isMysql = stripos($daoName, "mysql");
        $isMc = stripos($daoName, 'mc');
        $isRedis = stripos($daoName, 'redis');
        $fatherClass = substr($daoName, 0, strrpos($daoName, "_"));
        $classFile = $classPath . self::_getClassFile($fatherClass, $dirSeparator);
        if (!file_exists($classFile)) {
            $fatherClassContent = "<?php\n";
            $fatherClassContent .= "class {$fatherClass} extends";
            if ($isMysql !== false) {
                $fatherClassContent .= " BFW_Mysql {\n";
                $fatherClassContent .= "\tprotected \$_dbName = ''; // 数据库\n\n";
                $fatherClassContent .= "\tprotected function _getServer(\$rw) {\n";
                $fatherClassContent .= "\t\tif (!\$this->_dbName) throw new ErrorException(\"\$_dbName is empty!\", 30001);\n";
                $fatherClassContent .= "\t\t \$server = BFW_Config::get('mysql.' . \$this->_dbName); // 获取配置\n";
                $fatherClassContent .= "\t\t // \$server = array('dsn' => 'mysql:host=localhost', 'user' => 'userName', 'pass' => 'password', 'params' => array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8', PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true));\n";
                $fatherClassContent .= "\t\treturn \$server;\n";
                $fatherClassContent .= "\t}\n";
            } else if ($isMc !== false || $isRedis !== false) {
                if ($isMc !== false) {
                    $confName= "memcache";
                    $extends = "BFW_Memcache";
                    $server = "array(array('127.0.0.1', 12012, 1), array('127.0.0.1', 12012, 1))";
                }
                if ($isRedis !== false) {
                    $confName= "redis";
                    $extends = "BFW_Redis";
                    $server = "array('host' => '127.0.0.1', 'port' => 4396, 'timeout' => 0.1)";
                }
                $fatherClassContent .= " {$extends} {\n";
                $fatherClassContent .= "\tprotected \$_daoName;\n\n";
                $fatherClassContent .= "\tpublic function __construct() {\n";
                $fatherClassContent .= "\t\tif (!\$this->_daoName) throw new Exception('dao name is null!', 1);\n\n";
                $fatherClassContent .= "\t\t\$server = \$this->_getServer();\n";
                $fatherClassContent .= "\t\t\$this->_connect(\$server);\n";
                $fatherClassContent .= "\t}\n\n";
                $fatherClassContent .= "\t// 子类可以重载该方法\n";
                $fatherClassContent .= "\tprotected function _getServer() {\n";
                $fatherClassContent .= "\t\t// \$server = BFW_Config::get('{$confName}.'.\$this->_daoName);\n";
                $fatherClassContent .= "\t\t\$server = {$server};\n";
                $fatherClassContent .= "\t\treturn \$server;\n";
                $fatherClassContent .= "\t}\n";
            }
            $fatherClassContent .= "}\n";
            BFW_File::write($classFile, $fatherClassContent);
        }

        $classFile = $classPath . self::_getClassFile($daoName, $dirSeparator, false);
        if (file_exists($classFile)) throw new Exception("Error Processing Request", 10013);

        $daoNameVar = strtolower(str_replace("{$fatherClass}_", '', $daoName));
        $classFileContent = "<?php\n";
        $classFileContent .= "class {$daoName} extends {$fatherClass} {\n";
        if ($isMc !== false || $isRedis !== false) $classFileContent .= "\tprotected \$_daoName = '{$daoNameVar}';\n";
        $classFileContent .= "\tprivate static \$_single = null;\n\n";
        $classFileContent .= "\tpublic static function getInstance() {\n";
        $classFileContent .= "\t\tif (!self::\$_single) self::\$_single = new self;\n";
        $classFileContent .= "\t\treturn self::\$_single;\n";
        $classFileContent .= "\t}\n";
        if ($isMysql !== false) {
            $classFileContent .= "\n\tprivate function __construct() {\n";
            $classFileContent .= "\t\t//\$this->_dbName = 'dbName';\n";
            $classFileContent .= "\t\t//\$this->_table  = 'dbName.user';\n";
            $classFileContent .= "\t\t//\$this->_primary= 'user_id';\n";
			$classFileContent .= "\t}\n";

			//add by @tongzhen
			$classFileContent .= "\n\tprivate \$_dbName = '';\n";
			$classFileContent .= "\tprivate \$_table = '';\n";
			$classFileContent .= "\tprivate \$_primary = '';\n\n";

			$classFileContent .= "\t/**\n";
			$classFileContent .= "\t* 设置数据库名称\n";
			$classFileContent .= "\t* @param \$dbName\n";
			$classFileContent .= "\t*/\n";
			$classFileContent .= "\tpublic function setDBName(\$dbName){\n";
			$classFileContent .= "\t\t\$this->_dbName = \$dbName;\n";
			$classFileContent .= "\t}\n\n";

			$classFileContent .= "\t/**\n";
			$classFileContent .= "\t* 设置操作的表名\n";
			$classFileContent .= "\t* @param \$tableName\n";
			$classFileContent .= "\t*/\n";
			$classFileContent .= "\tpublic function setTableName(\$tableName){\n";
			$classFileContent .= "\t\t\$this->_table = \$tableName;\n";
			$classFileContent .= "\t}\n\n";

			$classFileContent .= "\t/**\n";
			$classFileContent .= "\t* 设置数据库名称\n";
			$classFileContent .= "\t* @param \$primary\n";
			$classFileContent .= "\t*/\n";
			$classFileContent .= "\tpublic function setTablePrimaryKey(\$keyName){\n";
			$classFileContent .= "\t\t\$this->_primary = \$keyName;\n";
			$classFileContent .= "\t}\n\n";
        }
        $classFileContent .= "}\n";

        BFW_File::write($classFile, $classFileContent);
        echo "dao {$daoName} create sucess!\n";
    }

    public static function newDaemon($argv) {
        if (!$argv) throw new Exception("Lost params! USE: php bfw.php newDaemon daemonName projectPath\n", 10009);
        if (empty($argv[2])) throw new Exception("Lost param daemonName!\n", 10010);
        if (empty($argv[3])) throw new Exception("Lost param projectPath!\n", 10011);
        if (!is_dir($argv[3])) throw new Exception("projectPath {$argv[3]} is not exists!\n", 10012);

		date_default_timezone_set('UTC');
		
		$dirSeparator = DIRECTORY_SEPARATOR;
        $daemonName = &$argv[2];
        $classPath = &$argv[3];
        $classPath .= "{$dirSeparator}class{$dirSeparator}daemon{$dirSeparator}{$daemonName}";
        $file = $classPath . ".php";

        if (file_exists($file)) throw new Exception("daemon '{$daemonName}' is exists!\n", 10013);

        $dir = __DIR__;
        $classFileContent = "<?php\n";
        $classFileContent .= "\$dir = dirname(dirname(__DIR__));\n";
        $classFileContent .= "define('PATH_LIB', '{$dir}/lib');\n";
        $classFileContent .= "define('PATH_CONFIG', \"{\$dir}/config\");\n";
        $classFileContent .= "define('PATH_CLASS', \"{\$dir}/class\");\n";
        $classFileContent .= "define('PATH_INCLUDE', \"{\$dir}/include\");\n";
        $classFileContent .= "define('PATH_LOG', \"{\$dir}/log\");\n\n";
        $classFileContent .= "require_once PATH_LIB . '/autoload.php';\n\n";

        $classFileContent .= "class daemon_{$daemonName} extends BFW_Daemon {\n";
        $classFileContent .= "\tprotected \$_maxWorks = 5;\n";
        $classFileContent .= "\tprotected \$_daemonName = '{$daemonName}';\n\n";
        $classFileContent .= "\tprotected function _run() {\n";
        $classFileContent .= "\t\t// your code\n";
        $classFileContent .= "\t}\n";
        $classFileContent .= "}\n\n";

        $classFileContent .= "\$cmds = array('start', 'stop', 'restart');\n";
        $classFileContent .= "\$cmd = isset(\$argv[1]) ? \$argv[1] : '';\n";
        $classFileContent .= "if (!\$cmd) die(\"command last!\\n\");\n";
        $classFileContent .= "if (!in_array(\$cmd, \$cmds)) die(\"{\$cmd} not exists!\\n\");\n";
        $classFileContent .= "\${$daemonName} = new daemon_{$daemonName};\n";
        $classFileContent .= "\${$daemonName}->\$cmd();";

        BFW_File::write($file, $classFileContent);
        echo "class {$daemonName} create sucess!\n";
    }

    private static function _getClassFile($class, $dirSeparator, $useEnd = true) {
    	$dir = str_replace('_', $dirSeparator, strtolower($class));
    	$position = strrpos($dir, $dirSeparator);
  	   	if ($position) $position += 1;
     	$endDir = substr($dir, $position);

        if ($useEnd) {
            $dir .= "{$dirSeparator}{$endDir}.php";
        } else {
            $dir .= ".php";
        }
     	return $dir;
    }
}

try {
	if (empty($argv[1])) throw new Exception("Lost params! Like: createProject | newClass | newDao\n", 1);
	$cmd = $argv[1];
	$cmdArr = array('createProject', 'newClass', 'newDao', 'newDaemon');
	if (!in_array($cmd, $cmdArr)) throw new Exception("The param '{$cmd}' is unlow! must be createProject | newClass | newDao | newDaemon\n", 2);

	unset($argv[0]);
	unset($argv[1]);

	define("PATH_LIB", __DIR__ . "/lib");

	require_once PATH_LIB . "/autoload.php";

	BFW::$cmd($argv);
} catch (Exception $e) {
	die($e->getMessage());
}
