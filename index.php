<!DOCTYPE html>
<!--
 * Email PHP - Easy Library
 * @Whatsapp +923464357146
 * @Email sheikhabdulrehman8@gmail.com
 * @Linkedin https://www.linkedin.com/in/abdulrehman-sheikh-a08695a7
-->
<html lang="en">
    <head>
        <title>Email PHP - Easy Library</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
        <style>
            .navbar-default {background-color: #337ab7;border-color: #337ab7;}
            .navbar-default .navbar-brand, .navbar-default .navbar-brand:focus, .navbar-default .navbar-brand:hover {color: #fff;background-color: transparent;}
            .alert{display: none;}
            img.img-responsive.imgLoader {position: fixed;top: 40%;right: 45%;z-index: 9999;display: none;}
        </style>
    </head>
    <body>
        <img class="img-responsive imgLoader" src="loader.gif">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.php">Email PHP - Easy Library</a>
                </div>
            </div>
        </nav>
        <div class="container">
            <div class="panel panel-primary">
                <div class="panel-heading">Contact Form - Easy Email</div>
                <div class="panel-body">
                    <form action="DataHandler.php" id="contact_form" enctype="multipart/form-data">
                        <div class="alert errorMsg"></div>

                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Full Name:</label>
                                    <input type="text" class="form-control" id="name" placeholder="Enter your name..." name="name">
                                </div>    
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email:</label>
                                    <input type="email" class="form-control" id="email" placeholder="Enter your email..." name="email">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="contact">Phone No. </label>
                                    <input type="tell" class="form-control" id="contact" placeholder="Enter your contact..." name="contact">
                                </div>    
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="anyFile">Attachements <small>(Multiple)</small>:</label>
                                    <input type="file" class="form-control" id="anyFile" name="anyFile" multiple>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group col-md-12">
                                <label for="location">Location: </label>
                                <input type="text" class="form-control" id="location" placeholder="Enter your location..." name="location">
                            </div>    
                        </div>
                        <div class="col-md-12">
                            <div class="form-group col-md-12">
                                <label for="message">Message: </label>
                                <textarea class="form-control" id="message" placeholder="Enter your message..." name="message"></textarea>
                            </div>    
                        </div>
                        <div class="col-md-12">
                            <div class="form-group col-md-12">
                                <button type="button" class="btn btn-default btn-submit" data-form="contact_form">Submit</button>
                            </div>    
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
<script>
    $(".btn-submit").click(function () {
        $("img.img-responsive.imgLoader").show();
        var btnClicked = $(this);
        var url = "DataHandler.php";
        var data = new FormData();

        if ($("#" + btnClicked.attr("data-form")).find('#anyFile').length === 1 && $("#" + btnClicked.attr("data-form")).find('#anyFile')[0].files[0] != undefined) {
            for (var k = 0; k < $("#" + btnClicked.attr("data-form")).find('#anyFile')[0].files.length; k++)
            {
                data.append('anyFile_' + k, $("#" + btnClicked.attr("data-form")).find('#anyFile')[0].files[k]);
            }
        }
        console.log(data);
        data.append('formData', $("#" + btnClicked.attr("data-form")).serialize());
        data.append('action', btnClicked.attr("data-form"));
        var ajax = new XMLHttpRequest();
        ajax.upload.addEventListener('progress', function (evt) {
            var percentage = (evt.loaded / evt.total) * 100;
        }, false);
        ajax.addEventListener('load', function (evt) {
            $("img.img-responsive.imgLoader").hide();
            var response = JSON.parse(evt.target.responseText);
            if (response['error'] == 1 || response['error'] == '1') {
                $(".errorMsg").fadeOut(function () {
                    var errorMsg = $(".errorMsg");
                    errorMsg.removeClass("alert-success");
                    errorMsg.removeClass("alert-danger");
                    errorMsg.addClass("alert-danger");
                    errorMsg.text(response['msg']);
                    errorMsg.fadeIn(function () {
                        setTimeout(function () {
                            errorMsg.fadeOut();
                        }, 5000);
                    });
                });
            } else {
                $(".errorMsg").fadeOut(function () {
                    var errorMsg = $(".errorMsg");
                    errorMsg.removeClass("alert-success");
                    errorMsg.removeClass("alert-danger");
                    errorMsg.addClass("alert-success");
                    errorMsg.text(response['msg']);
                    errorMsg.fadeIn(function () {
                        $("#" + btnClicked.attr("data-form"))[0].reset();
                        setTimeout(function () {
                            errorMsg.fadeOut();
                        }, 5000);
                    });
                });
            }
        }, false);
        ajax.addEventListener('error', function (evt) {
        }, false);
        ajax.addEventListener('abort', function (evt) {
        }, false);
        ajax.open('POST', url);
        ajax.send(data);
        return false;
    });
</script>
