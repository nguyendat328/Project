<?php
    $home = new XTemplate("views/tables/faq.html");


    $home->parse("FAQ");
    $content = $home->text("FAQ");

?>