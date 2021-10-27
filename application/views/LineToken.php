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
        <!-- <script>
            $.ajax({
                type:'POST',
                url:"http://172.16.1.44/PHP_API/index.php/LineNotify/GetAuthorizeCode",
                data:{ token: },
                success: function (result){
                    $('#response').show().html(result);
                }
            })
        </script> -->
    </head>
    <body>
        
    </body>
</html>