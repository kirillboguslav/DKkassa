<?php
if (!getUser()) {
    header("Location: /login");
}
?>
<h3 align="center">Чеки</h3>
<form method="post">
<input type="submit" name="ch" value="Добавить пустой чек">
</form>
<?php
if (isset($_POST['ch'])) {
    add_check();
}
?>

<?php
$query = 'SELECT * FROM `check` where 1=1 order by id desc ';
$result = select($query);
$i=0;
$delch = 'delch';
while(count($result) > $i){
    echo '<button><a href="/main/check/'.$result[$i]['id'].'">номер '.$result[$i]['id'].' - дата чека : '.$result[$i]['date'].'</a></button> <button><a href="/main/sale/dell/'.$result[$i]['id'].'">Удалить</a></button><br>';
    $i++;
}
?>

