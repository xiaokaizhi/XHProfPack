<?php
/**
 * 发送邮件测试类
 * @author	tongzhen <tongzhen@live.com>
 * @date	2014-03-21 09:37:20
 *
 * http://localhost/githubelite/bfwphpapp/evaluate/app.php?target=Mod_mailtest
 *
 */
class Mod_mailtest extends Mod {
	public function run() {
		//echo __METHOD__;
		
		//配置邮件
		Obj_mail::setHost("imap.126.com");
		Obj_mail::setSMTPAuth(true);
		Obj_mail::setUserMailBox('elitetongzhen@126.com');
		Obj_mail::setFromUserPassword('');
		Obj_mail::setMailPort(25);
		Obj_mail::setFromUserMailbox('elitetongzhen@126.com');
		Obj_mail::setFromName('tongzhen');

		//send email
		$toUserMailBox_arr = array('','elitetongzhen@126.com',);

		$title = 'This is title';
		$content = 'This is content';
		//$content=iconv("UTF-8","GB2312", $content);

		if($toUserMailBox_arr && $title && $content){
			Obj_mail::sendMail($toUserMailBox_arr,$title,$content);
			echo 'Send Success!';
		}
	}
}
