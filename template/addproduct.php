<?php
if (isset($bar) and selectbarcode($bar) != true) {
    if (isset($_POST['add'])) {
        addproductsql($bar, $_POST['title'], $_POST['artikl']);
        addtovarostatok($bar, $_POST['cena'], $_POST['roznica']);
        header('Location: /naklstovar/' . $id);
        exit();
    }
} else {
    header('Location: /naklstovar/' . $id);
}
?>

<hr>
<h1>Добавить новый Товар?</h1>
<form method="POST">
    <p>Баркод <input type="text" name="barcode" size="10" value="<?php echo $bar; ?>"></p>
    <p>Название товара <input type="text" size="50" name="title" required></p>
    <p>Артикул <input type="text" size="15" name="artikl" required></p>
    <p>Цена <input type="text" size="5" name="cena" value="0"></p>
    <p>Розница <input type="text" size="5" name="roznica" value="0"></p>
    <input type="submit" name="add" value="добавить">
</form>'
