<!DOCTYPE html>
<html lang="tw">
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    </head>
    <body>
        <script>
            var email = '<?= $email ?>';
            var URL = 'https://notify-bot.line.me/oauth/authorize?';
                URL += 'response_type=code';
                URL += '&client_id=AozwCtchOfAAovlPFxAt42'; //CLIENT_ID
                URL += '&redirect_uri=https://192.168.170.110/PHP_API/index.php/LineNotify/GetAuthorizeCode?email=<?= $email ?>'; //Callback URL
                URL += '&scope=notify';
                URL += '&state=NO_STATE';
                window.location.href = URL;
        </script>
    </body>
</html>