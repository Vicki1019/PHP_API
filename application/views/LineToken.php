<!DOCTYPE html>
<html lang="tw">
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- <script src="LineNotify.js"> </script> -->
        <?php
            include_once("application\controllers\LineNotify.php");
            $lineNotify = new lineNotify();
            $code = $_GET['code'];
            $token = $lineNotify->GetToken($code);
            print $token;


        ?>
    </head>
    <body>
        
    </body>
</html>