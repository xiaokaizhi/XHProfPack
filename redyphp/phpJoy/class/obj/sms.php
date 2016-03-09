<?php
/**
 * 发送邮件类
 * @author tongzhen
 */
class obj_sms extends obj_Abstract {
	/**
	 * @param array() $mailBox
	 * @param string $title
	 * @param string $content
	 */
	public static function send($message, $phoneNo){
		if ($message && $phoneNo){

			$url = 'http://i.api.sina.cn/push/sms.php';

			$message = mb_convert_encoding( $message, 'GBK', 'UTF-8' );
			$param = array(
						//'msg' =>  urlencode($message),
						'msg' =>  $message,
						'tel' =>  $phoneNo,
						'check' => substr(md5($phoneNo), 1, 3) . substr(md5($phoneNo), 7, 2) . substr(md5($message), 3, 2),

					);

			lib_curl::setData($param);
			$json = lib_curl::call($url, 0.1, array());
			echo $url.'?'.http_build_query($param);echo "\n";
			echo $json."\n";

			$data = array();
			$data = json_decode($json, true);
			if(isset($data['code']) && $data['code'] == 1){
				return true;
			}else {
				return false;
			}
		}
	}
	
}
