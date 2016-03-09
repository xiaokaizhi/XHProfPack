<?php
/**
 * controller
 * @author baojunbo <baojunbo@gmail.com>
 */
class BFW_Controller {
	private static $_method = 'run';
	private static $_classes = array();

	public static function get($classMethod, $args = null) {
		if (!$classMethod) throw new ErrorException(__FILE__  . ":" . __LINE__ . " classMethod is empty! " , 1001);

		if ($args) {
			if (!is_array($args)) {
				$args = (array)$args;
			}
		} else {
			$args = func_get_args();
			unset($args[0]);
		}

		$classMethod = explode('.', $classMethod);
		$class = &$classMethod[0];
		if (!empty($classMethod[1])) self::$_method = &$classMethod[1];
		if (!isset(self::$_classes[$class])) {
			self::$_classes[$class] = new $class;
		}
		return call_user_func_array(array(self::$_classes[$class], self::$_method), $args);
		// return call_user_method_array(self::$_method, self::$_classes[$class], $args);
	}
}