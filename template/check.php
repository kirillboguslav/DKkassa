<?php
if (!getUser()) {
    header("Location: /login");
}
$query3 = 'SELECT * FROM `check` where 1=1 order by id desc';
$result3 = select($query3);
$chek = $result3[0]['id'] + 1;

if (isset($_POST['barcode']) and seltovar($_POST['barcode']) == true) {
    if (istovarcheck($_POST['barcode'], $id) != true) {
        addtovarCheck($_POST['barcode'], $id);
    } else {
        updatetovarcheck($_POST['barcode'], $id);
    }
}
if ($_POST['prodat']) {
    add_check();
    echo '<script type="text/javascript">
            window.location.href=window.location.href;
            location.replace("/main/");
            </script>';
}
if ($_POST['bar'] and $_POST['kolvo']) {
    $kol = $_POST['kolvo'] * -1;
    updatetovarcheckkolvo($_POST['bar'], $kol, $id);
}
if ($_POST['bar'] and $_POST['roznica']) {
    updatetovarcheckroznica($_POST['bar'], $_POST['roznica'], $id);
}

?>
<div class="prod">
    <div class="blok1">
        <?php
        if (empty($id)) {
            echo '
            <a href="/main/check/' . $chek . '"><button class="newCh">Новый чек</button></a>
            <button class="newCh">Возврат</button>
            ';
        }
        if (isset($id)) {
            echo '
            <table>
            <tr>
                <td class="c">Штрихкод</td>
                <td class="c">Номенклатура</td>
                <td class="c">Арт</td>
                <td class="c">Шт</td>
                <td class="c">Закуп</td>
                <td class="c">Продаж</td>
                <td class="c"></td>
            </tr>';

            $query4 = 'SELECT * FROM `tovar_ostatki` where  num_check=' . $id;
            $result4 = select($query4);
            $out = '';

            for ($i = 0; count($result4) > $i; $i++) {

                $out .= '<tr><td>' . $result4[$i]['barcode'] . '</td>';

                $query5 = 'SELECT * FROM `products` where  barcode=' . $result4[$i]['barcode'];
                $result5 = select($query5);

                for ($k = 0; count($result5) > $k; $k++) {
                    $out .= '<td>' . $result5[$k]['title'] . '</td><td>' . $result5[$k]['artikl'] . '</td>';
                }
                $out .= '<form method="post"><td class="c"><input type="hidden"  name="bar" value="' . $result4[$i]['barcode'] . '"><input type="text" name="kolvo" size="1" value="' . $result4[$i]['kolvo'] * (-1) . '"></form></td>';
                $out .= '<td>' . $result4[$i]['cena'] . '</td>';
                $out .= '<form method="post"><td class="c"><input type="hidden"  name="bar" value="' . $result4[$i]['barcode'] . '"><input type="text" name="roznica" size="1" value="' . $result4[$i]['roznica'] . '"></form></td>';
                $out .= '<td><a href="/main/check/' . $id . '/' . $result4[$i]['barcode'] . '"><button>Удалить</button></a></td></tr>';
            }
            echo $out;
            echo '</table>';
        }
        //Получаем название первого ключа масива
        //echo  key($_POST).'<br><br>';
        //echo  $_POST[key($_POST)];
        ?>
    </div>
    <div class="blok2">
        <?php
        echo '<table>
            <tr>
                <td class="c">Штрихкод</td>
                <td class="c">Номенклатура</td>
                <td class="c">Артикул</td>
                <td class="c">Шт</td>
                <td class="c">Розница</td>
            </tr>';
        $query2 = 'SELECT barcode, SUM(kolvo) AS kolvo from `tovar_ostatki` where 1=1 group by barcode';
        $result2 = select($query2);
        $out = '';
        for ($i = 0; count($result2) > $i; $i++) {
            if ($result2[$i]['kolvo'] == 0) {
                continue;
            }
            $query = 'SELECT * FROM `products` where barcode=' . $result2[$i]['barcode'];
            $result = select($query);
            $out .= '<tr><td>' . $result2[$i]['barcode'] . '</td><td>' . $result[0]['title'] . '</td><td>' . $result[0]['artikl'] . '</td><td class="c">' . $result2[$i]['kolvo'].'</td><td class="c">' . lastroznica($result2[$i]['barcode']) . '</td></tr>';
        }
        echo $out;
        echo '</table>';
        ?>
    </div>
</div>
<?php
if (isset($id)) {
    $query1 = 'SELECT id FROM `check` where id=' . $id;
    $result1 = select($query1);
    if ($result1[0]['id'] != $id) {
        echo '
                <div>
                    <form method="post">
                       <input type="submit" name="prodat" value="Продать" size="35">
                   </form>
                </div>
                ';
    }
}
if (isset($id)) {
    echo '
    <form method="post">
    <p class="p"><input type="text" name="barcode" size="35" autofocus></p>
    </form>
    ';

}
?>


<style type="text/css">
    td {
        border-bottom: grey solid 1px;
        padding-right: 15px;
        padding-left: 5px;
    }

    .c {
        text-align: center;
    }

    .prod {
        width: 100%;
        display: flex;
        border: black dashed 1px;
        margin: 2px;
        height: 300px;
    }

    .blok1 {
        width: 60%;
        border: black dashed 1px;
        margin: 3px;
        background: aliceblue;
        text-align: center;
        font-family: Calibri;
    }

    .blok2 {
        width: 40%;
        border: black dashed 1px;
        margin: 3px;
        overflow: scroll;
        font-family: Calibri;
    }

    .p {
        text-align: right;
    }

    .newCh {
        Justify-content: center;
        height: 50%;
        width: 100%;
        font-size: 50px;
    }
</style>