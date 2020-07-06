<?php
    $home = new XTemplate("views/Foods/detail.html");

    if (isset($_GET['detail'])) {
        $detail = $_GET['detail'];
        $query = "SELECT * FROM food WHERE id = '$detail'";
        $query2 = "SELECT * FROM food WHERE id != '$detail' ORDER BY RAND() LIMIT 0,3";
        $result2 = $db->fetchAll($query2);

        
        $result = $db->fetchAll($query);
        foreach($result as $vals) {
            $home->assign('morefood',$vals);
            $home->parse('fooddetail.morefood');
        }

        foreach($result2 as $value) {
            $home->assign('moreitem',$value);
            $home->parse('fooddetail.moreitem');
        }
    }



    $home->parse("fooddetail");
    $content = $home->text("fooddetail");