<?php
    $home = new XTemplate("views/Dogs/detail.html");
    $home->assign('baseUrl',$baseUrl);

    if (isset($_GET['detail'])) {
        $detail = $_GET['detail'];
        $query = "SELECT * FROM dogs WHERE id = '$detail'";
        $query2 = "SELECT * FROM dogs WHERE id != '$detail' ORDER BY RAND() LIMIT 3";
        $result2 = $db->fetchAll($query2);

        $sql = "SELECT * FROM news WHERE highlight=1 ORDER BY RAND() LIMIT 4";
        $rs = $db->fetchALL($sql);
        $result = $db->fetchAll($query);
        foreach($result as $vals) {
            $home->assign('more',$vals);
            $home->parse('detaildog.moredogdetail');
        }
        foreach($rs as $val) {
            $home->assign('moredog',$val);
            $home->parse('detaildog.moredog');
        }
        foreach($result2 as $value) {
            $home->assign('moreitem',$value);
            $home->parse('detaildog.moreitem');
        }
    }



    $home->parse("detaildog");
    $content = $home->text("detaildog");