<?php
   if(is_array($argv)){
      $title=$argv[1];
  //var_dump($title);
     $title=iconv("UTF-8", "GB2312", $title);
    //  var_dump($title);
       if(file_exists($argv[2])){
      $content=file_get_contents($argv[2]);
      // $content = str_replace("\n", "<br>", $content);
      // echo mb_detect_encoding($content);
      $content=iconv("UTF-8","GB2312", $content);
      # echo '<body{background-image:url("C:\Documents and Settings\Administrator\����\DSC_0129.jpg");width:250px;height:362px;text-align:left;}>';
     # echo $content;
      }else{
      $content=$argv[2];
      $content=iconv("UTF-8", "GB2312", $content);
      //echo $content;
      }
      $to_str=$argv[3];
      $to=split(",", $to_str);
  }else{
      return;
  }
require("PHPMailer.php"); //���ص��ļ�������ڸ��ļ�����Ŀ¼
$mail = new PHPMailer(); //�����ʼ�������
$mail->IsSMTP(); // ʹ��SMTP��ʽ����
$mail->Host = ""; // �����ҵ�ʾ�����
$mail->SMTPAuth = true; // ����SMTP��֤����
$mail->Username = ""; // �ʾ��û���(����д�����email��ַ)
$mail->Password = ""; // �ʾ�����
$mail->Port=25;
$mail->From = ""; //�ʼ�������email��ַ
$mail->FromName = "";
foreach ($to as $address){
    $tmp=split("@", $address);
    $name=$tmp[0];
    $mail->AddAddress("$address", $name);//�ռ��˵�ַ�������滻���κ���Ҫ�����ʼ���email����,��ʽ��AddAddress("�ռ���email","�ռ�������")

}
//$mail->AddReplyTo("", "");

//$mail->AddAttachment("/var/tmp/file.tar.gz"); // ��Ӹ���
//$mail->IsHTML(true); // set email format to HTML //�Ƿ�ʹ��HTML��ʽ

$mail->Subject = $title; //�ʼ�����
$mail->Body = $content; //�ʼ�����
$mail->AltBody = "ext content"; //������Ϣ������ʡ��

if(!$mail->Send())
{
file_put_contents('mail_error.log',var_export($mail->ErrorInfo,true),FILE_APPEND);
exit;
}
