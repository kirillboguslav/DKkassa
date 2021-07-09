<?php
if (!getUser()) {
header("Location: /login");
}
?>
    <style type="text/css">
    .d {
        text-align: center;
        /*border: black solid 1px;*/
        position: absolute;
        top: -65px;
        left: -5px;
        font-size: 12px;
    }
    </style>
<div class="d">
    <?php
    include 'barcode.php';
    $generator = new barcode_generator();
    $options = array();


    $query = 'SELECT * FROM `products` where barcode='.$bar;
    $result = select($query);
    $query1 = 'SELECT * FROM `tovar_ostatki` where barcode='.$bar.' order by date DESC';
    $result1 = select($query1);

    $svg = $generator->render_svg('ean-13', $bar, $options);
    echo $svg;
    echo '<br>'.$result[0]['artikl'].'<br>';
    echo $result[0]['title'].'<br>';
    echo '<b>'.$result1[0]['roznica'].' грн';

    //$generator->output_image('png', 'ean-13', '4823037600700', $options);
    //Используйте с GET или POST:
    //barcode.php?f={format}&s={symbology}&d={data}&{options}
    //barcode.php?f=png&s=ean-13&d=9781234567888
    ?>
</div>