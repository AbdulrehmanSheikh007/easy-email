<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EmailUtilities
 * @Email PHP - Easy Library
 * @author Abdul Rehman
 * @Whatsapp +923464357146
 * @Email sheikhabdulrehman8@gmail.com
 * @Linkedin https://www.linkedin.com/in/abdulrehman-sheikh-a08695a7
 */
class EmailUtilities {

    protected $_header = [];
    protected $_subject = "Email PHP - Easy Library";
    protected $_body = "";
    protected $_fromName = "Abdulrehman Sheikh";
    protected $_fromEmail = "sheikhabdulrehman8@gmail.com";
    protected $_toEmail = "sheikhabdulrehman8@gmail.com";
    protected $_host = "smtp.gmail.com";
    protected $_username = "sheikhabdulrehman8@gmail.com";
    protected $_password = "***********";
    protected $_SMTPSecure = "tls";
    protected $_port = 587;
    protected $_json_response = [];
    protected $attachement = [];

    public function __construct() {
        
    }

    public function setBody($value) {
        $this->_body = $value;
        return $this;
    }

    public function setSubject($value) {
        $this->_subject = $value;
        return $this;
    }

    public function setToEmail($value) {
        $this->_toEmail = $value;
        return $this;
    }

    public function setAttachement($value) {
        $this->attachement = $value;
        return $this;
    }

    public function sendEmail() {

        require_once 'phpmailer/PHPMailerAutoload.php';

        $mail = new PHPMailer;
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = $this->_host;              // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication.p
        $mail->Username = $this->_username;                 // SMTP username
        $mail->Password = $this->_password;                           // SMTP password
        $mail->SMTPSecure = $this->_SMTPSecure;                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = $this->_port;                                    // TCP port to connect to

        $mail->From = $this->_fromEmail;
        $mail->FromName = $this->_fromName;     // Name is optional
        $mail->addAddress($this->_toEmail);
        //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        if (!empty($this->attachement)) {
            for ($k = 0; $k < count($this->attachement); $k++) {
                foreach ($this->attachement[$k] as $key => $val) {
                    $mail->addAttachment($key, $val);
                }
            }
        }

        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = $this->_subject;
        $mail->Body = $this->_body;

        $mail->AltBody = $this->_body;

        $_json_response = array('error' => 0, 'msg' => 'Email have been sent successfully.');

        if (!$mail->send()) {
            $_json_response = array('error' => 1, 'msg' => 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo);
        }

        return $_json_response;
    }

}
