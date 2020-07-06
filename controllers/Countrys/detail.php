<?php
    $home = new XTemplate("views/Countrys/detail.html");
    $home->assign('baseUrl',$baseUrl);
    if (isset($_GET['detail'])) {
        $detail = $_GET['detail'];
        $query = "SELECT * from country where id = '$detail'";
        $query2 = "SELECT * from country where id != '$detail' ORDER BY RAND() limit 3";
        $result2 = $db->fetchAll($query2);
        $sql1 = "SELECT dogs.id FROM dogs , country , dogs_country WHERE country.id = dogs_country.id_country and dogs_country.id_dogs = dogs.id and dogs_country.id_country = '$detail'";
        $rs1 = $db->fetchALL($sql1);

        $sql = "SELECT dogs.dog_name,dogs.id,  dogs.img, dogs.subcontent FROM dogs , country , dogs_country WHERE country.id = dogs_country.id_country and dogs_country.id_dogs = dogs.id and dogs_country.id_country = '$detail' limit 0,3";
        $rs = $db->fetchALL($sql);
        $result = $db->fetchAll($query);
        foreach($result as $vals) {
            $home->assign('more',$vals);
            $home->parse('detailcountry.morecountry');
        }
        foreach($rs as $val) {
            $home->assign('moredog',$val);
            $home->parse('detailcountry.moredog');
        }
        if (count($rs1) > 3) {
            $home->parse('detailcountry.seemore');
        }
        foreach($result2 as $value) {
            $home->assign('moreitem',$value);
            $home->parse('detailcountry.moreitem');
        }
    }



    $home->parse("detailcountry");
    $content = $home->text("detailcountry");