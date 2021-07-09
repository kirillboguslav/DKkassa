<?php
/**
 * register page template
 */

$out ='';
if (isset($_POST['submit'])) {
    $err = [];
    if (strlen($_POST['login']) < 4 or strlen($_POST['login']) > 30) {
        $err[] = "Логин не меньше 4 и не больше 30";
    }
    if (isLoginExist($_POST['login'])) {
        $err[] = "Логин существует";
    }
    if (count($err) === 0) {
        createUser($_POST['login'], $_POST['password']);
//        header('Location: /login');
        exit();
    } else {
        $out = '<h4>Ошибки регистрации</h4>';
        foreach ($err as $error) {
            $out.= $error . '<br>';
        }
    }
}
?>
<div>
    <h3>Зарегистрировать нового пользывателя</h3>
    <form method="POST">
        <p></p>Login: <input type="text" name="login" required></p>
        <p>Pass: <input type="text" name="password" required></p>
        <input type="submit" name="submit" value="Регистрация">
    </form>
    <p>
        <a href="/main">Скрыть</a>
    </p>
</div>
    <?php echo $out;?>

