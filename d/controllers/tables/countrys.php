<?php
    $home = new XTemplate("views/tables/countrys.html");


    $home->parse("COUNTRY");
    $content = $home->text("COUNTRY");

?>