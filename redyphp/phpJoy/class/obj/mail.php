<?php
/**
 * 发送邮件类
 * @author tongzhen
 */
class obj_mail extends obj_Abstract {
	/**
	 * @param array() $mailBox
	 * @param string $title
	 * @param string $content
	 */
	public static function sendMail($mailBox,$title,$content){
		if ($mailBox && $title && $content){
			$mail = new lib_mail_PHPMailer();
			$mail->IsSMTP();
			$mail->Host = "smtp.sina.cn";
			$mail->SMTPAuth = true;
			$mail->Username = "elitetongzhen@sina.cn";
			$mail->Password = "";//@ask Name2014
			$mail->Port = 25;
			$mail->From = 'elitetongzhen@sina.cn';
			$mail->FromName = 'tongzhen';
		
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
