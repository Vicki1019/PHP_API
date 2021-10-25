<!DOCTYPE html>
<html lang="tw">
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- <script src="LineNotify.js"> </script> -->
    </head>
    <body>
        <script>
            var URL = 'https://notify-bot.line.me/oauth/authorize?';
                URL += 'response_type=code';
                URL += '&client_id=AozwCtchOfAAovlPFxAt42'; //CLIENT_ID
                URL += '&redirect_uri=https://10.0.66.15/PHP_API/index.php/LineNotify/GetAuthorizeCode'; //Callback URL
                URL += '&scope=notify';
                URL += '&state=NO_STATE';
                window.location.href = URL;
        </script>
    </body>
</html>