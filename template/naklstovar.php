<?php
if (!getUser()) {
    header("Location: /login");
}

$query = "select * from nakl_vhod where id=" . $id;
$result = select($query);

$out = '';
if (isset($_POST['submit'])) {
    $err = [];
    if (strlen($_POST['barcode']) < 13 or strlen($_POST['barcode']) > 13) {
        $err[] = "Баркод не 13 цыфр";
    }
    if (selectbarcode($_POST['barcode'])) {
        $err[] = "Товар добавлен";
        insertfornakl($_POST['barcode'], $result[0]['id']);
    }
    if (count($err) === 0) {
        $bar = $_POST['barcode'];
        $id = $result[0]['id'];
        header("Location: /naklstovar/" . $result[0]['id'] . "/addproduct/" . $_POST['barcode']);
        exit();
    } else {
        $out = '<h4>Действие по штрихкоду</h4>';
        foreach ($err as $error) {
            $out .= $error . '<br>';
        }
    }
}
echo "<h1>накладная " . $result[0]['id'] . " от " . $result[0]['date'] . " </h1>";
echo '<hr>';
?>

<form method="POST">
    <input type="text" name="barcode" autofocus>
    <input type="submit" name="submit" value="добавить товар">
</form>
<?php
echo $out;
$query9 = "select * from tovar_ostatki where num_nakl=" . $result[0]['id'];
$result = select($query9);
$out = '';
$out1 = 0;
echo '<form method="POST">';
echo '<table >';

for ($i = 0; count($result) > $i; $i++) {
    $out .= '<tr><td>';
    $out .= $result[$i]['barcode'] . ' - ';
    $query1 = "select * from products where barcode=" . $result[$i]['barcode'];
    $result1 = select($query1);
    for ($k = 0; count($result1) > $k; $k++) {
        $out .= $result1[$k]['title'] . ' ';
        $out .= $result1[$k]['artikl'] . ' ';
        $out .= '</td><td>';
    }
    $out .= '<input type="hidden" name="bar' . $i . '" value="' . $result[$i]['barcode'] . '">';
    $out .= '<input type="hidden" name="num_nakl' . $i . '" value="' . $result[$i]['num_nakl'] . '">';
    $out .= '<input type="text" name="kolvo' . $i . '" size="1" value="' . $result[$i]['kolvo'] . '"> ';
    $out .= '<input type="text" name="cena' . $i . '" size="1" value="' . $result[$i]['cena'] . '"> ';
    $out .= '<input type="text" name="roznica' . $i . '" size="1" value="' . $result[$i]['roznica'] . '"> ';
    $out .= '<button><a href="/naklstovar/delltovar/' . $result[$i]['id'] . '/' . $result[$i]['num_nakl'] . '">Удалить</a></button> ';
    $out .= '<button><a target="_blank" href="/print/' . $result[$i]['barcode'] . '">Печать</a></button><br>';
    $out .= '</td></tr>';
    $out1 += $result[$i]['kolvo'] * $result[$i]['cena'];
}
$ch = $i;
echo $out;
echo '<tr><td></td><td>Сума закупки - ' . $out1 . '</td></tr>';
echo '</table>';
///////////////////////
if (isset($_POST['seve_nakl'])) {
    for ($i = 0; $ch > $i; $i++) {
        $bar = 'bar';
        $num_nakl = 'num_nakl';
        $kolvo = 'kolvo';
        $cena = 'cena';
        $roznica = 'roznica';
        updatetovarlist($_POST[$kolvo . $i], $_POST[$cena . $i],$_POST[$roznica . $i], $_POST[$bar . $i],$_POST[$num_nakl . $i]);
    }
}
//////////////
echo '<input type="submit" name="seve_nakl" value="Сохранить"> ';
echo ' <button>Обновить</button> ';
echo ' <button><a href="/main/nakl">Выход</a></button>';
echo '</form>';
?>
<style type="text/css">
    a{
        text-decoration: none;
        color: black;
    }
</style>
