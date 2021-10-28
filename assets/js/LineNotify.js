var URL = 'https://notify-bot.line.me/oauth/authorize?';
URL += 'response_type=code';
URL += '&client_id=AozwCtchOfAAovlPFxAt42'; //CLIENT_ID
URL += '&redirect_uri=https://192.168.1.213/PHP_API/index.php/LineNotify/GetAuthorizeCode'; //Callback URL
URL += '&scope=notify';
URL += '&state=NO_STATE';
console.log(URL);

$.ajax({
    type: "GET",
    url: URL,
    dataType: "JSON",
    data: '',
    async: true,
    success: res => {
        console.log(res)
    },
    error: err => {
        console.log(err)
    },
});
window.location.href = URL;
// http://192.168.1.213/PHP_API/index.php/LineNotify/LineAuthorize