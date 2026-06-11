<?php

/*Codigo responsavél por reter as informações do Mailtrap para enviar os e-mail.*/

require __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;

class MailSender{
    
    private $phpmailer =  null;
    
    public function __construct(  ) {
        $this->phpmailer=  new PHPMailer();
        $this->phpmailer->isSMTP();
        $this->phpmailer->Host                    = 'sandbox.smtp.mailtrap.io';
        $this->phpmailer->SMTPAuth      = true;
        $this->phpmailer->Port                    = 2525;
        $this->phpmailer->Username       = '327fb0d82bfa35';
        $this->phpmailer->Password        = 'a562d06e63e067';
    }

    public function send($fromEmail,$fromName,  $toEmail , $toName, $subject, $body,  $isHtml) {
        $this->phpmailer->setFrom($fromEmail, $fromName);
        $this->phpmailer->addAddress($toEmail, $toName);
        $this->phpmailer->isHTML( $isHtml);
        $this->phpmailer->Subject = $subject;
        $this->phpmailer->Body = $body;
        $this->phpmailer->CharSet  = 'UTF-8';
        $this->phpmailer->Encoding = 'base64';
        $this->phpmailer ->send();
    }
    
}

?>