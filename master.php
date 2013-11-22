<?php
    global $login;
    global $content;
    global $title;
    global $nav;

?><!DOCTYPE html>
<html>
    <head>
        <title><?php echo $title; ?></title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    </head>
    <body>
        <div id="header">
            <h1 style="text-align:center"><img src="head.jpg" alt="head"></h1>
        </div>        
        <?php 
        if($nav != ""){
            include($nav);
        }?>
        <!-- contents -->
        <?php include($content); ?>        
            <div id="footer" style="background-color:#FFA500;clear:both;text-align:center;">
                <p>Copyright &#169 http://studweb.cosc.canterbury.ac.nz/~iju13/classicmodels/index.php</p>
            </div>
        </div>
    </body>
</html>
