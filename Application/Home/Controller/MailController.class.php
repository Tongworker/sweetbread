<?php
namespace Home\Controller;
use Think\Controller;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// composer 邮件发送
class MailController extends Controller {
        
    /**
     * [index 首页，编辑信息]
     * @仝朋朋:http://
     * @url示例:
     * @DateTime    2018-08-27
     * @逻辑:
     * @Author      仝朋朋
     * @return      [web]     [description]
     */
    public function index() {

    }

    public function sendMail() 
    {
        require ($_SERVER['DOCUMENT_ROOT'].__ROOT__.'/vendor/autoload.php');

        $mail = new PHPMailer(true);   
        try {
            //Server settings
            $mail->SMTPDebug = 2;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.163.com;';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = '15166960507@163.com';                 // SMTP username
            $mail->Password = 'tppadmin1';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            // $mail->Port = 587;                                    // TCP port to connect to

            //Recipients
            $mail->setFrom('15166960507@163.com', '程序员小T'); // 发送人
            $mail->addAddress('2282507533@qq.com', '月');     // Add a recipient  接收人 可多条
            $mail->addAddress('1483425810@qq.com', '仝');               // Name is optional
            // $mail->addReplyTo('info@example.com', 'Information');
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');

            //Attachments
            // $mail->addAttachment('./a.txt', '文件');         // Add attachments
            // $mail->addAttachment('./Boss_v1.1.0_20170518.apk', '安卓软件');    // Optional name

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = '大傻子';   // 邮件标题
            $mail->Body    = '大傻子发给了二傻子';  // 邮件内容
            // $mail->AltBody = '测试1231232';   // 附加信息 可以省略

            $mail->send();
            echo '发送成功';
        } catch (Exception $e) {
            echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
        }

    }

}