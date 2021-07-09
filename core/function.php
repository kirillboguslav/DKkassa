<?php
function explodeURL($url)
{
    return explode("/", $url);
    // функция для расделение слешом
}

function getArticle($url)
{
    $query = "select * from info where url='" . $url . "'";
    return select($query)[0];
}

function getCategory($url)
{
    $query = "select * from category where url='" . $url . "'";
    return select($query)[0];
}

function getCategoryArticle($cid)
{
    $query = "select * from info where cid=" . $cid;
    return select($query);
}

function isLoginExist($login)
{
    $query = "select id from kassir where login='" . $login . "'";
    $result = select($query);
    if (count($result) === 0) return false;
    return true;
}

function createUser($login, $password)
{
    $password = md5(md5(trim($password)));
    $login = trim($login);
    $query = "INSERT INTO kassir SET login='" . $login . "', password='" . $password . "'";
    return execQuery($query);
}

function login($login, $password)
{
    $password = md5(md5(trim($password)));
    $login = trim($login);
    $query = "SELECT id, login from kassir WHERE login='" . $login . "' AND password='" . $password . "'";
    $result = select($query);
    if (count($result) != 0) return $result;
    return false;
}

function generateCode($length = 7)
{
    $chars = "qwertyuiopasdfghjklzxcvbnmQWERTYUIOPLKJHGFDSAZXCVBNM1723456789";
    $code = "";
    $clen = strlen($chars) - 1;
    while (strlen($code) < $length) {
        $code .= $chars[mt_rand(0, $clen)];
    }
    return $code;
}

function updateUser($id, $hash, $ip)
{
    if (is_null($ip)) {
        $query = "UPDATE kassir SET hash='" . $hash . "' WHERE id=" . $id;
    } else {
        $query = "UPDATE kassir SET hash='" . $hash . "', ip=INET_ATON('" . $ip . "') WHERE id=" . $id;
    }
    return execQuery($query);
}

function getUser()
{
    if (isset($_COOKIE['id']) and isset($_COOKIE['hash'])) {
        $query = "SELECT id, login, hash, INET_NTOA(ip) as ip FROM kassir WHERE id = " . intval($_COOKIE['id']) . " LIMIT 1";
        $user = select($query);
        if (count($user) === 0) {
            return false;
        } else {
            $user = $user[0];
            if ($user['hash'] !== $_COOKIE['hash']) {
                clearCookies();
                return false;
            }
            if (!is_null($user['ip'])) {
                if ($user['ip'] !== $_SERVER['REMOTE_ADDR']) {
                    clearCookies();
                    return false;
                }
            }
            $_GET['login'] = $user['login'];
            return true;
        }

    } else {
        clearCookies();
        return false;
    }
}

function clearCookies()
{
    setcookie('id', "", time() - 60 * 60 * 24 * 30, "/");
    setcookie('hash', "", time() - 60 * 60 * 24 * 30, "/", null, null, true);
    unset($_GET['login']);
}

function createArticle($title, $url, $descr_min, $description, $cid, $image)
{
    $query = "INSERT INTO info (title, url, descr_min, description, cid, image) VALUES ('" . $title . "', '" . $url . "','" . $descr_min . "','" . $description . "'," . $cid . ",'" . $image . "')";
    return execQuery($query);
}

function updateArticle($id, $title, $url, $descr_min, $description, $cid, $image)
{
    $query = "UPDATE info SET title='" . $title . "', url='" . $url . "', descr_min='" . $descr_min . "', description='" . $description . "', cid=" . $cid . ", image='" . $image . "' WHERE id=" . $id;
    return execQuery($query);
}

function logout()
{
    clearCookies();
    header("Location: /");
    exit;
}

///////////////////////////////////////////////////////////// МОИ  ФУНКИИ /////////////////
function seltovar($bar){
    $query = "SELECT SUM(kolvo) AS kolvo FROM `tovar_ostatki` where barcode=" . $bar;
    $result = select($query);
    if($result[0]['kolvo'] > 0){
        return true;
    }
    return false;
}
function addtovarCheck($bar, $id){
    $query10 = "SELECT * FROM `tovar_ostatki` where barcode=".$bar." order by date DESC";
    $result10 = select($query10);
    $query = "INSERT INTO `tovar_ostatki` SET barcode='" . $bar . "', num_check='".$id."', kolvo=-1 , date='".date("Y-m-d H:i:s")."', cena='".$result10[0]['cena']."', roznica='".$result10[0]['roznica']."'";
    return execQuery($query);
}

function istovarcheck($bar, $id){
    $query = "SELECT * FROM `tovar_ostatki` where barcode='". $bar."' and num_check=".$id;
    return $result = select($query);
}
function updatetovarcheck($bar, $id){
//    $query = "SELECT * FROM `tovar_ostatki` where barcode='". $bar."' and num_check=".$id;
//    $result = select($query);
    $query1 = "UPDATE `tovar_ostatki` SET kolvo = kolvo -1 WHERE barcode =".$bar." and num_check =".$id;
    return execQuery($query1);
}
function lastroznica($bar){
    $query = "SELECT * FROM `tovar_ostatki` WHERE barcode='" . $bar . "' AND num_check <= 0 ORDER BY `tovar_ostatki`.`date` DESC";
    $result = select($query);
    return $result[0]['roznica'];
}

function updatetovarcheckkolvo($bar,$kol,$id){
    $query = "UPDATE `tovar_ostatki` SET kolvo = '" . $kol . "'  WHERE barcode='" . $bar . "' AND num_check='" . $id . "'";
    return execQuery($query);
}
function updatetovarcheckroznica($bar,$roz,$id){
    $query = "UPDATE `tovar_ostatki` SET roznica = '" . $roz . "'  WHERE barcode='" . $bar . "' AND num_check='" . $id . "'";
    return execQuery($query);
}

function add_check(){
    $query = "INSERT INTO `check` SET type=0, date='" . date("Y-m-d H:i:s") . "'";
    return execQuery($query);
}

function dell_checkTovar($id){
    $query = "DELETE FROM `tovar_ostatki` WHERE `tovar_ostatki`.`num_check` =".$id;
    return execQuery($query);
}

function dell_tocarwihtcheck($id,$bar){
    $query = "DELETE FROM `tovar_ostatki` WHERE `tovar_ostatki`.`num_check` =".$id." and barcode=".$bar;
    header("Location: /main/check/".$id);
    return execQuery($query);
}

function dell_check($id){
    $query = "DELETE FROM `check` WHERE id=".$id;
    header("Location: /main/sale");
    return execQuery($query);
}


function addproductsql($barcode, $title, $artikl)
{
    $barcode = trim($barcode);
    $title = trim($title);
    $artikl = trim($artikl);
    $query = "INSERT INTO products SET barcode='" . $barcode . "', title='" . $title . "', artikl='" . $artikl . "'";
    return  execQuery($query);
}

function addtovarostatok($barcode, $cena, $roznica)
{
    $barcode = trim($barcode);
    $cena = trim($cena);
    $roznica = trim($roznica);
    $query = "INSERT INTO tovar_ostatki SET barcode='" . $barcode . "', cena='" . $cena . "', roznica='" . $roznica . "', date='".date("Y-m-d H:i:s")."'";
    return execQuery($query);
}

function selectbarcode($bar){
    $query = "select barcode from products where barcode=" . $bar;
    return select($query);
}

function insertfornakl($bar, $num_nakl)
{
    $query = "select * from tovar_ostatki where num_nakl='" . $num_nakl . "' AND barcode='" . $bar . "'";
    $query1 = "select * from tovar_ostatki where num_nakl=0 AND barcode='" . $bar . "'";
    $result1 = select($query1);
    if (select($query) == true) {
        $result = select($query);
        $result[0]['kolvo'] = $result[0]['kolvo'] + 1;
        $query = "UPDATE tovar_ostatki SET kolvo='" . $result[0]['kolvo'] . "' WHERE barcode='" . $bar . "' AND num_nakl=" . $num_nakl;
        return execQuery($query);
    }
    $query2 = "INSERT INTO tovar_ostatki SET barcode='" . $bar . "', num_nakl='" . $num_nakl . "', kolvo=1, cena='".$result1[0]['cena']."', roznica='".$result1[0]['roznica']."', date='" . date("Y-m-d H:i:s") . "'";
    return execQuery($query2);
}

function add_nakl(){
    $query = "INSERT INTO nakl_vhod SET type=0, date='" . date("Y-m-d H:i:s") . "'";
    header("Location: /main/nakl");
    return execQuery($query);
}

function dell_nakl_tovar_s_nakl($idtovar, $idnakl){
    $query = "DELETE FROM `tovar_ostatki` WHERE `tovar_ostatki`.`num_nakl` ='".$idnakl."' AND id='".$idtovar."'";
    header("Location: /naklstovar/$idnakl");
    return execQuery($query);
}

function dell_nakl_tovar($gps){
    $query = "DELETE FROM `tovar_ostatki` WHERE `tovar_ostatki`.`num_nakl` ='".$gps."'";
    return execQuery($query);
}

function dell_nakl($gps){
    $query = "DELETE FROM `nakl_vhod` WHERE `nakl_vhod`.`id` = '".$gps."'";
    header("Location: /main/nakl");
    return execQuery($query);
}

function updatetovarlist($kolvo, $cena, $roznica, $barcode, $num_nakl)
{
    $query = "UPDATE `tovar_ostatki` SET kolvo = '" . $kolvo . "', cena='" . $cena . "', roznica='" . $roznica . "' WHERE barcode='" . $barcode . "' AND num_nakl='" . $num_nakl . "'";
    return execQuery($query);

}

?>