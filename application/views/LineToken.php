<!DOCTYPE html>
<html lang="tw">
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
        <!-- <script src="LineNotify.js"> </script> -->
        <?php
            // include_once("application\controllers\LineNotify.php");
            // $lineNotify = new lineNotify();
            // $code = $_GET['code'];
            // $token = $lineNotify->GetToken($code);
            // print $token;
            // http://192.168.1.213/PHP_API/index.php/LineNotify/LineAuthorize
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
        <?php
        print($code);
        ?>
        <script>
            const code = '<?= $code?>';
            $.ajax({
                type:'POST',
                url: "<?= site_url()?>/LineNotify/GetToken",
                data:{
                    code: code,
                },
                success: function (result){
                    // console.log(result);
                    var token = result;
                }
            })
        </script>
    </body>
</html>