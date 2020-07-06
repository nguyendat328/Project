<?php
    $home = new XTemplate("views/news/detail.html");
    $home->assign('baseUrl',$baseUrl);

    if (isset($_GET['detail'])) {
        $detail = $_GET['detail'];
        $query = "SELECT * from news where id= '$detail'";
        $sql = "SELECT * from news where id != '$detail' ORDER BY RAND() limit 3 ";
        $rs = $db->fetchALL($sql);
        $result = $db->fetchAll($query);
        foreach($result as $vals) {
            $home->assign('more',$vals);
            $home->parse('DETAIL.more');
        }
        foreach($rs as $val) {
            $home->assign('moreitem',$val);
            $home->parse('DETAIL.moreitem');
        }
    }



    $home->parse("DETAIL");
    $content = $home->text("DETAIL");

?>