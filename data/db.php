<?php
//pripojeni do db na serveru eso.vse.cz
$db = new PDO('mysql:host=127.0.0.1;dbname=sucs00;charset=utf8', 'sucs00', 'GufZte8C0IpBaNofr2');
//vyhazuje vyjimky v pripade neplatneho SQL vyrazu
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION)
?>

