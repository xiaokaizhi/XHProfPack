<?php
/**
 * MysqlPage
 * @author	baojunbo <baojunbo@gmail.com>
 */

class lib_MysqlPage {
    private static $_mysql;
    private static $_totalRows = 0;
    private static $_perPage   = 10;
    private static $_group     = 10;
    private static $_pageInfo  = array(); // 分页信息

	public static function get($mysql, $where, $fields, $params, $config) {
		self::$_mysql = $mysql;
		$res = array(
			'totalRows'   => 0,
			'totalPages'  => 0,
			'currentPage' => 0,
			'data'        => array(),
			'pages'       => array(),
		);

		$totals = $mysql->get($where, "COUNT(*) AS totals", $params);
		if (!empty($totals['totals'])) self::$_totalRows = &$totals['totals'];
		if (!self::$_totalRows) return $res;

		// 设置每页显示数量及分组
		if (!empty($config['perPage'])) self::$_perPage = &$config['perPage'];
		if (!empty($config['group'])) self::$_group = &$config['group'];

		self::_setPageInfo();

		$res['totalRows'] = self::$_totalRows;
		$res['totalPages'] = self::$_pageInfo['totalPages'];
		$res['currentPage'] = self::$_pageInfo['pageId'];
		$res['data'] = self::_getData($where, $fields, $params);
		$res['pages'] = self::_getPages();

		return $res;
    }

    private static function _setPageInfo() {
    	$totalRows = self::$_totalRows;
    	$perPage   = self::$_perPage;
    	$group     = self::$_group;

    	$pageId = lib_Request::request('pageId', 0);
    	$groupId= lib_Request::request('groupId', 0);
    	if (!$pageId) $pageId = 1;
    	if (!$groupId) {
    		$groupId = 1;
    	} else {
    		$pageId = ($groupId - 1) * $group + 1;
    	}
    	$start = ($pageId - 1) * $perPage;
    	$totalPages  = ceil($totalRows / $perPage);
    	$totalGroups = ceil($totalPages / $group);
    	self::$_pageInfo = array(
    		'start' => $start,
    		'pageId' => $pageId,
    		'groupId' => $groupId,
    		'totalPages' => $totalPages,
    		'totalGroups'=> $totalGroups
    	);
    }

    private static function _getData($where, $fields, $params) {
    	$where .= " LIMIT " . self::$_pageInfo['start'] . ", " . self::$_perPage;
    	$data = self::$_mysql->mget($where, $fields, $params);
    	return $data;
    }

    private static function _getPages() {
    	$pages = array();
    	$minPage = (self::$_pageInfo['groupId'] - 1) * self::$_group + 1;
    	$maxPage = $minPage + self::$_group - 1;
    	if ($maxPage > self::$_pageInfo['totalPages']) $maxPage = &self::$_pageInfo['totalPages'];
    	for ($p = $minPage; $p <= $maxPage; $p ++) {
    		$pages[] = $p;
    	}
    	return $pages;
    }
}
