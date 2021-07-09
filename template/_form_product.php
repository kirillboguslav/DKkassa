<form action="" method="POST" enctype="multipart/form-data">
    barcode<hr><input type="text" name="title" value="<?php echo $result['title']; ?>">
    <hr>opisanie_etiketki<hr><input type="text" name="url" value="<?php echo $result['url']; ?>">
    <hr>price<hr><input type="text" name="url" value="<?php echo $result['url']; ?>">
    <hr><input type="submit" name="submit" value="<?php echo $action; ?>">
</form>
<!--<form action="" method="POST" enctype="multipart/form-data">-->
<!--    <p>Title: <input type="text" name="title" value="--><?php //echo $result['title']; ?><!--"></p>-->
<!--    <p>URL: <input type="text" name="url" value="--><?php //echo $result['url']; ?><!--"></p>-->
<!--    <p>MIn Descr: <textarea name="descr_min">--><?php //echo $result['descr_min']; ?><!--</textarea></p>-->
<!--    <p>Descr: <textarea name="description">--><?php //echo $result['description']; ?><!--</textarea></p>-->
<!--    <p>Category:-->
<!--        <select name="cid">-->
<!--            --><?php
//            $out = '';
//            for ($i = 0; $i < count($category); $i++) {
//                if ($category[$i]['id'] === result['cid']) {
//                    $out .= '<option value="' . $category[$i]['id'] . '" selected>' . $category[$i]['title'] . "</option>";
//                } else {
//                    $out .= '<option value="' . $category[$i]['id'] . '">' . $category[$i]['title'] . "</option>";
//                }
//            }
//            echo $out;
//            ?>
<!--        </select>-->
<!--    </p>-->
<!--    <p>ФОТО<input type="file" name="image" value="--><?php //echo $result['image']; ?><!--"></p>-->
<!--    --><?php
//    if (isset($result['image']) and $result['image'] != '') {
//        echo '<img src="/static/images/' . $result['image'] . '" style="width:100px">';
//    }
//    ?>
<!--    <p><input type="submit" name="submit" value="--><?php //echo $action; ?><!--"></p>-->
<!--</form>-->