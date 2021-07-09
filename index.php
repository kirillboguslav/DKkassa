<?php
require_once 'config/db.php';
require_once 'core/function_db.php';
require_once 'core/function.php';
$conn = connect();

$gps = $_GET['gps']; // NULL!
$gps = explodeURL($gps);

switch ($gps) {
    case ($gps[0] == ''):
        require_once 'template/site.php';
        break;
    case ($gps[0] == 'main' and $gps[1] == 'check' and isset($gps[2]) and isset($gps[3])):
        dell_tocarwihtcheck($gps[2],$gps[3]);
        break;
    case ($gps[0] == 'main' and $gps[1] == 'check' and isset($gps[2])):
        $id = $gps[2];
        require_once 'template/main.php';
        require_once 'template/check.php';
        break;
    case ($gps[0] == 'main' and $gps[1] == 'register'):
        require_once 'template/main.php';
        require_once 'template/register.php';
        break;
    case ($gps[0] == 'main' and $gps[1] == 'sale' and $gps[2] == 'dell' and isset($gps[3])):
        $id = $gps[3];
        dell_checkTovar($id);
        dell_check($id);
        break;
    case ($gps[0] == 'main' and $gps[1] == 'sale'):
        require_once 'template/main.php';
        require_once 'template/sale.php';
        break;
    case ($gps[0] == 'main' and $gps[1] == 'nakl'):
        require_once 'template/main.php';
        require_once 'template/nakl.php';
        break;
    case ($gps[0] == 'main' and $gps[1] == 'sklad'):
        require_once 'template/main.php';
        require_once 'template/sklad.php';
        break;
    case ($gps[0] == 'naklstovar' and isset($gps[1]) and $gps[2] == 'addproduct' and isset($gps[3])):
        $id = $gps[1];
        $bar = $gps[3];
        require_once 'template/addproduct.php.';
        break;
    case ($gps[0] == 'naklstovar' and $gps[1] == 'delltovar' and isset($gps[2]) and isset($gps[3])):
        dell_nakl_tovar_s_nakl($gps[2], $gps[3]);
        break;
    case ($gps[0] == 'naklstovar' and $gps[1] == 'del' and isset($gps[2])):
        dell_nakl_tovar($gps[2]);
        dell_nakl($gps[2]);
        break;
    case ($gps[0] == 'naklstovar' and empty($gps[1])):
        add_nakl();
        break;
    case ($gps[0] == 'naklstovar' and isset($gps[1])):
        $id = $gps[1];
        require_once 'template/naklstovar.php';
        break;
    case ($gps[0] == 'login'):
        require_once 'template/login.php';
        break;
    case ($gps[0] == 'print' and isset($gps[1])):
        $bar = $gps[1];
        require_once 'template/print.php';
        break;
    case ($gps[0] == 'main'):
        require_once 'template/main.php';
        require_once 'template/check.php';
        break;
    default:
        require_once 'template/404.php';
}
?>