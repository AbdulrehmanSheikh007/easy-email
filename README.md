# Email PHP - Easy Library - AJAX Based - PHPMailer
Email PHP - Easy Library
This library have 2 classes one is for emailutilities and the other one is for data handling. You can setup your credentials in email utilities class and then you can post your data to data handler class direct. This library have phpmailer library itegrated.

You can use this library on your localhost or on anywhere. This file will sent bulk emails from your localhost as well. Just you have to follow these steps.

1. Change your email and password credentials in EmailUtilities class
2. Put this library on your htdocs or www folder and extract
3. Hit this folder via http://localhost/your_folder_path
4. You will get a complete contact form from which you can fill the data and attach multiple files
5. If you want to check which files you can upload, you can just visit the DataHandler class and there will be a list of files array as protected variable.
6. You can submit the form and simply you will get an email with multiple attachements.

Note: If you want to set different subjects and different sendTo email, you can set in parser method for different kind of actions you can set different subjects manually. If you want to setup different custom validations for different forms, you can simply add your custom validator function in DataHandler class and call it for different kind of actions in parser function in replacement of customValidation() function.
