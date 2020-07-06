<?php
    $home = new XTemplate("views/tables/foods.html");


    $home->parse("FOOD");
    $content = $home->text("FOOD");
?>