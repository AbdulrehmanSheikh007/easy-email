<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DataHandler
 * @Email PHP - Easy Library
 * @author Abdul Rehman
 * @Whatsapp +923464357146
 * @Email sheikhabdulrehman8@gmail.com
 * @Linkedin https://www.linkedin.com/in/abdulrehman-sheikh-a08695a7
 */
class DataHandler {

    protected $_body;
    protected $_params = [];
    protected $_attachments = [];
    protected $_Subject = 'Email PHP - Easy Library';
    protected $_filetypes = array("image/jpeg", "image/png", "image/jpg", "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "application/zip", "application/pdf", "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");

    public function __construct() {
        
    }

    public function getParams() {
        return $this->_params;
    }

    public function getBody() {
        return $this->_body;
    }

    public function validator() {
        $json = array();

        if (!isset($this->_params['name']) || empty($this->_params['name'])) {
            $json = array("error" => 1, "msg" => "Please provide your name.");
        }

        if (!isset($this->_params['contact']) || empty($this->_params['contact'])) {
            $json = array("error" => 1, "msg" => "Please provide your contact number.");
        }

        if (!isset($this->_params['email']) || empty($this->_params['email']) || !filter_var($this->_params['email'], FILTER_VALIDATE_EMAIL)) {
            $json = array("error" => 1, "msg" => "Please provide a valid email.");
        }

        if (!isset($this->_params['message']) || empty($this->_params['message'])) {
            $json = array("error" => 1, "msg" => "Please write something in the text box.");
        }

        if (!empty($json)) {
            echo json_encode($json);
            exit;
        }

        return $this;
    }

    public function CustomValidator() {
        $json = array();

        if (!isset($this->_params['location']) || empty($this->_params['location'])) {
            $json = array("error" => 1, "msg" => "Please provide your location.");
        }

        if (!empty($json)) {
            echo json_encode($json);
            exit;
        }

        return $this;
    }

    public function unserialize($str) {
        $str = urldecode($str);
        $returndata = array();
        $strArray = explode("&", $str);
        $i = 0;
        foreach ($strArray as $item) {
            $array = explode("=", $item);
            $returndata[$array[0]] = $array[1];
        }

        $this->_params = $returndata;
        return $this;
    }

    public function setAttachements() {
        if (!empty($_FILES) && count($_FILES) > 0) {
            foreach ($_FILES as $key => $val) {
                if (!in_array(mime_content_type($val['tmp_name']), $this->_filetypes)) {
                    $json = array("error" => 1, "msg" => "Uploaded file type is invalid. Please provide a valid file.");
                    echo json_encode($json);
                    exit;
                }

                $this->_attachments[] = array($val['tmp_name'] => time() . $val['name']);
            }
        }
        return $this;
    }

    public function setBody() {
        $search = array('[SUBJECT]', '[NAME]', '[EMAIL]', '[CONTACTNO]', '[LOCATION]', '[MESSAGE]');
        $replace = array(
            ucfirst($this->_Subject),
            ucfirst($this->_params['name']),
            ucfirst($this->_params['email']),
            ucfirst($this->_params['contact']),
            (isset($this->_params['location']) && !empty($this->_params['location'])) ? ucfirst($this->_params['location']) : "",
            ucfirst($this->_params['message']),
        );

        $html = str_replace($search, $replace, file_get_contents('email-template.html'));
        $this->_body = $html;
        return $this;
    }

    public function parseData($request) {
        require_once 'EmailUtilities.php';
        $EmailUtils = new EmailUtilities();

        if ($request['action'] == 'contact_form') {
            $HTMLBody = $this->unserialize($request['formData'])->validator()->CustomValidator()->setAttachements()->setBody()->getBody();
            $EmailUtils = $EmailUtils->setAttachement($this->_attachments)->setSubject($this->_Subject)->setBody($HTMLBody);
        }

        $Response = $EmailUtils->sendEmail();
        echo json_encode($Response);
        exit;
    }

}

if (isset($_REQUEST['action']) && !empty($_REQUEST['action'])) {
    $DataHandler = new DataHandler();
    $Response = $DataHandler->parseData($_REQUEST);
}


