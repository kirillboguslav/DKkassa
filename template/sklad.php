<h3>Товарные остатки</h3>
<?php
if (!getUser()) {
    header("Location: /login");
}
echo '<table>
<tr>
<td class="c">Штрихкод</td>
<td class="c">Номенклатура</td>
<td class="c">Артикул</td>
<td class="c">Закупка</td>
<td class="c">Розница</td>
<td class="c">Количество</td>
<td class="c">Ценник</td>
</tr>';
$query = 'SELECT barcode, SUM(kolvo) AS kolvo,cena,roznica from `tovar_ostatki` where 1=1 group by barcode order by kolvo DESC';
$result = select($query);
$out = '';
for($i=0; count($result)>$i; $i++){
    $query1 = 'SELECT * from `products` where barcode='.$result[$i]['barcode'];
    $result1 = select($query1);
    $out .= '<tr><td>'.$result[$i]['barcode'].'</td><td>'.$result1[0]['title'].'</td><td>'.$result1[0]['artikl'].'</td><td class="c">'.$result[$i]['cena'].'</td><td class="c">'.lastroznica($result[$i]['barcode']).'</td><td class="c">'.$result[$i]['kolvo'].'</td>';
    $out .= '<td><button><a target="_blank" href="/print/' . $result[$i]['barcode'] . '">Печать</a></button></td></tr>';
}
echo $out;



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
</style>
