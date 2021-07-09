<?php
$out ='';
if (isset($_POST['submit'])) {
    $user = login($_POST['login'], $_POST['password']);
    if ($user) {
        $user = $user[0];
        $hash = md5(generateCode(10));
        $ip = null;
        if (!empty($_POST['ip'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        updateUser($user['id'], $hash, $ip);
        setcookie('id', $user['id'], time() + 60 * 60 * 24 * 30, "/");
        setcookie('hash', $hash, time() + 60 * 60 * 24 * 30, "/");
        header("Location: /");
        exit();
    }
    else {
        $out = 'Вы неправильно ввели логин или пароль!';
    }
}
$query = 'select * from kassir';
$result = select($query);
$out = '';
for ($i = 0; count($result) > $i; $i++){
    $out .= '<option>'.$result[$i]['login'].'</option>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <style type="text/css">
        .admin {
            text-align: center;
            font-family: Calibri;
        }
    </style>
</head>
<body>
<div class="admin">
    <img src="/static/img_site/dp.png" alt="">
    <br>
    <img src="/static/img_site/application-pgp-signature.webp" alt="">
    <br>
    <form action="" method="post">
        Логин<br>
        <select name="login">
            <?php echo $out; ?>
        </select>
        <br>Пароль<br>
        <input type="password" name="password" required><br>
        Прикреплять к IP: <input type="checkbox" checked="checked" name="ip"><br>
        <input type="submit" name="submit" value="Войти">
    </form>
</div>
</body>
</html>

