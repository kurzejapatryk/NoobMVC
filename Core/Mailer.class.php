<?php

namespace Core;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

/**
 * Mailer Class
 * Class for handling emails
 * @package Core
 */
class Mailer{

    /**
     * send function
     * Function for sending an email
     * @param string $to Recipient
     * @param string $subject Subject
     * @param string $message Content
     * @param array $Attachment Attachments
     * @return bool
     * @access public
     */
  public static function send($to, $subject, $message, $Attachment = []){
    $mail = new PHPMailer(true);
    try {
        if(isset($_SERVER['CI']) && $_SERVER['CI'] == 'true'){
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
        } else {
            $mail->SMTPDebug = SMTP::DEBUG_OFF;
        }
        $mail->isSMTP();
        $mail->CharSet = "UTF-8";
        $mail->Host = MAIL_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = MAIL_USER;
        $mail->Password = MAIL_PASS;
        
        // Set the encryption system
        switch(MAIL_ENCRYPTION){
            case 'ssl':
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                break;
            case 'tls':
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                break;
            default:
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                break;
        }

        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = MAIL_PORT;

        $mail->setFrom(MAIL_USER, APP_NAME);
        $mail->addAddress($to);

        // Attachments
        foreach($Attachment as $file){
            $mail->addAttachment($file);
        }

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;

        $result = $mail->send();
        return $result;
    } catch (Exception $e) {
        return false;
    }
  }

}
