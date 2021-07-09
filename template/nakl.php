<h1>Накладные:</h1>
<button><a href="/naklstovar/">Новая накладная</a></button>
<?php
if (!getUser()) {
    header("Location: /login");
}
?>

<br><br>
<?php
$query = 'select * from nakl_vhod';
$result = select($query);
$out = '';
for ($i = 0; count($result) > $i; $i++) {
    $num = $result[$i]['id'];
    $out .= '<button><a href="/naklstovar/'.$num.'">Приходная накладная № '.$num;
    $out .= ' Дата - ';
    $out .= $result[$i]['date'].'</a></button> <button><a href="/naklstovar/del/'.$num.'">Удалить</a></button><br>';
}
echo $out;
?>
