<?php
if (!getUser()) {
    header("Location: /login");
}
?>
<style type="text/css">
    .flx {
        display: flex;
        /*flex-direction: row;*/
        text-align: center;
        border: black dashed 1px;
        padding-bottom: 5px;
    }
    a {
        text-decoration: none;
        color: black;
    }
</style>
<div class="flx">
    <a href="/main/"><img src="/static/img_site/iconfinder_home512x512_197589%20(1).png" alt="На главную"><br>
        <button>Главная</button>
    </a>
    <a href="/main/register"><img src="/static/img_site/thefreeforty_register-128.webp" alt=""><br>
        <button>Регистрация</button>
    </a>
    <a href="/main/nakl"><img src="/static/img_site/iconfinder_349-Document_Add_2124277.png" alt=""><br>
        <button>накладные</button>
    </a>
    <a href="/main/sklad"><img src="/static/img_site/iconfinder_Warehouse_2_4265793.png" alt=""><br>
        <button>склад</button>
    </a>
    <a href="/main/sale"><img src="/static/img_site/iconfinder_Shop-sale-circus-shopping_3357491.png" alt=""><br>
        <button>Продажа</button>
    </a>
</div>








