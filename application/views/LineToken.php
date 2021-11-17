<!DOCTYPE html>
<html lang="tw">
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.10/dist/sweetalert2.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.1.10/dist/sweetalert2.all.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </head>
    <body>
        <?php
        print($code);
        print("<br>" . $state);
        print("<br> email = " . $email);
        ?>
        <script>
            const code = '<?= $code?>';
            const email = '<?= $email?>';
            $.ajax({
                type:'POST',
                url: "<?= site_url()?>/LineNotify/GetToken",
                data:{
                    code: code,
                    email: email,
                },
                success: function (result){
                    console.log(result);
                    const token = result.substr(1, (result.length-2));
                    console.log(token);
                    $.ajax({
                        type:'POST',
                        url: "<?= site_url()?>/LineNotify/saveToken",
                        data:{
                            token: token,
                            email: email,
                        },
                        success: function (result){
                            console.log(result);
                            if (result !== "success") {
                                alert('串接失敗');
                            } else {
                                Swal.fire({
                                    title: '<strong>串接成功！</strong>',
                                    icon: 'info',
                                    html:
                                        '恭喜，已成功串接生活冰館，<br>' +
                                        '我們還需要您把他帶進群組，<br>' +
                                        '這樣他才能盡責的提醒^^~',
                                    confirmButtonText: '好的, 跳轉到Line',
                                    showCancelButton: true,
                                    cancelButtonText: '回生活冰館'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        uri = 'https://line.me/R/nv/chat';
                                        window.location.href = uri;
                                    }
                                })
                            }
                        }
                    })
                }
            })
        </script>
    </body>
</html>