<?php
/**
 * url
 * @author Junbo Bao <baojunbo@gmail.com>
 * @create on: 2013-07-16 18:20:31
 */

class lib_url {
	public static function call($url, $method = 'GET', $timeout = 1, $data = array(), $header = null,$isCookies=false) {
		lib_curl::setData($data, $method);
		lib_curl::setHttpHeader($header);		
		if (defined('CURLOPT_TIMEOUT_MS')) {
			$timeoutMS = $timeout * 1000;
			lib_curl::setOptions(CURLOPT_NOSIGNAL, 1);
			lib_curl::setOptions(CURLOPT_CONNECTTIMEOUT_MS, $timeoutMS);
			lib_curl::setOptions(CURLOPT_TIMEOUT_MS, $timeoutMS);
		} else {
			if ($timeout < 1) $timeout = 1;
			lib_curl::setOptions(CURLOPT_CONNECTTIMEOUT, $timeout);
			lib_curl::setOptions(CURLOPT_TIMEOUT, $timeout);
		}
		
		if ($isCookies){//通过cookie方式调用
			$sue = urlencode(lib_request::cookie('SUE'));
			$sup = urlencode(lib_request::cookie('SUP'));
			if (!$sue) $sue = 'es%3Dc29810e526c9e3af6571a1195937e776%26ev%3Dv1%26es2%3D6a576c08eff155f923daea59ce9cfe73%26rs0%3DTvgYJnYkS5sPvKnsbmy6%252BibFVLnvnZy0dvKZUCCYQNrqaCiWZLhgGy1b9QhLa8aqob6ScecjRl7aMe08yWCpET2MlCBY6hClogoozyxxHXWX119iReSpK%252BaKRQaNWyMV7eFCqayPMucncZDlHUjzdy7TG8qOX84WCTW0zUhe3OA%253D%26rv%3D0';
			if (!$sup) $sup = 'cv%3D1%26bt%3D1383103780%26et%3D1383190180%26d%3Dc909%26i%3Dffc4%26us%3D1%26vf%3D0%26vt%3D0%26ac%3D0%26st%3D0%26uid%3D1644879743%26name%3Dbaojunbo%2540gmail.com%26nick%3D%25E4%25B8%25AD%25E5%259B%25BD%25E9%2583%25A8%25E9%2598%259F%26fmp%3D%26lcp%3D';
			lib_curl::setCookie('SUE', $sue);
			lib_curl::setCookie('SUP', $sup);
		}
		$content = lib_curl::call($url);
		return $content;
	}	
}
