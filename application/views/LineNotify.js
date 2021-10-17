function oAuth() {
    var URL = 'https://notify-bot.line.me/oauth/authorize?';
    URL += 'response_type=code';
    URL += '&client_id=AozwCtchOfAAovlPFxAt42'; //CLIENT_ID
    URL += '&redirect_uri=http://localhost:3000/'; //Callback URL
    URL += '&scope=notify';
    URL += '&state=NO_STATE';
    window.location.href = URL;
}