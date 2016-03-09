<?php
/**
 * 发送邮件类
 * @author tongzhen
 */
class Obj_mail extends Obj {

	private static $_host ='';

	private static $_SMTPAuth = true;

	private static $_userMailBox = '';

	private static $_password = '';

	private static $_port = 25;

	private static $_from = '';

	private static $_fromName = '';

	public static function setHost($host){
		self::$_host = $host;
	}

	public static function setSMTPAuth($flag=true){
		self::$_SMTPAuth = $flag;
	}

	public static function setUserMailBox($mailBox){
		self::$_userMailBox = $mailBox;
	}

	public static function setFromUserPassword($passWord){
		self::$_password = $passWord;
	}

	public static function setMailPort($port){
		self::$_port = $port;
	}

	public static function setFromUserMailBox($mailBox){
		self::$_from = $mailBox;
	}

	public static function setFromName($name){
		self::$_fromName = $name;
	}
	/**
	 * @param array() $mailBox
	 * @param string $title
	 * @param string $content
	 */
	public static function sendMail($mailBox,$title,$content){
		if ($mailBox && $title && $content){
			$mail = new BFW_mail_PHPMailer();
			$mail->IsSMTP();
			$mail->Host = self::$_host;
			$mail->SMTPAuth = self::$_SMTPAuth;
			$mail->Username = self::$_userMailBox;
			$mail->Password = self::$_password;
			$mail->Port = self::$_port;
			$mail->From = self::$_from;
			$mail->FromName = self::$_fromName;
		
			foreach($mailBox as $box){
				$tmp_arr = array();
				$tmp_arr = explode('@', $box);
				$name  = $tmp_arr[0];
				$mail->AddAddress($box, $name);
			}
			
			$mail->Subject = $title;
			$mail->Body = $content;
			if(!$mail->Send()){
				file_put_contents('mail_error.log',var_export($mail->ErrorInfo,true),FILE_APPEND);
			}
		}
	}
	
}
