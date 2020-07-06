<?php
    $home = new XTemplate("views/tables/gallery.html");


    $home->parse("GALLERY");
    $content = $home->text("GALLERY");

?>