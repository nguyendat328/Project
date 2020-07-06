<?php
    $home = new XTemplate("views/tables/faq.html");
    $pagetitle = "Patrona - FAQs Page";

    $hxtp->assign('pagetitle',$pagetitle);
    $sql= "SELECT * FROM faq";
    $nbr = 1;
    $result = $db->fetchAll($sql);
    foreach($result as $val) {
        $val['nbr'] = $nbr++;
        $home->assign('LIST',$val);
        $home->parse('FAQ.wh');
        
    }



    $home->parse("FAQ");
    $content = $home->text("FAQ");

?>