<?php
    $home = new XTemplate("views/tables/care.html");


    $home->parse("CARE");
    $content = $home->text("CARE");

?>