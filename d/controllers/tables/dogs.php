<?php
    $home = new XTemplate("views/tables/dogs.html");
    // $dog->assign('baseUrl',$baseUrl);
    $home->parse("DOG");
	$content = $home->text("DOG"); 
?>