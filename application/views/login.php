<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

    <title>Document</title>
</head>
<body>
    <form action="<?= site_url()?>/Login/login" method="post">
        <input type="text" id="email" name="email" placeholder="帳號" required>
        <div class="tab"></div>
        <input type="text" id="passwd" name="passwd" placeholder="密碼" required>
        <div class="tab"></div>
        <input type="submit" value="登入" class="submit">
    </form>
</body>
</html>