<?php
    $home = new XTemplate("views/tables/gallery.html");
    $home->assign('baseUrl',$baseUrl);
    $pagetitle = "Patrona - Gallery Page";

    $hxtp->assign('pagetitle',$pagetitle);
    $limit = 12;

    $sql1 = "SELECT id FROM gallery where 1";
    $rs = $db->fetchAll($sql1);
    $total_records = count($rs);
    // var_dump ($total_records);die;
    if ($total_records==0) {
        $mes = "Không tìm thấy bản ghi!";
        $home->assign('mes', $mes);

    } else {
        // limit and current_page
        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;      
        // total_page
        $total_page = ceil($total_records / $limit);
        // page 1
        if ($current_page > $total_page){
            $current_page = $total_page;
        }
        else if ($current_page < 1){
            $current_page = 1;
        }
        // start
        $start = ($current_page - 1) * $limit;
        // pre button
        if($current_page>1 && $total_page>1){
            $pre = $current_page-1;
            $home->assign('next',"");  
            $home->assign('pre',$pre);
        }else{ 
            $home->assign('prev',"disabled");
            $home->assign('prev',$current_page);
        }
        ///
        for($i=1;$i<=$total_page;$i++){
            if($i==$current_page){
                $home->assign('active',"list-active");
                $home->assign('i',$i);
                $home->parse('GALLERY.PAGE');
            }else{
                $home->assign('active',"");
                $home->assign('i',$i);  
                $home->parse('GALLERY.PAGE');
            }
        }
        // next
        if ($current_page < $total_page && $total_page >1) {
            $next = $current_page + 1;
            $home->assign('next',"");
            $home->assign('next1',$next);
        } else {
            $home->assign('next',"disabled");
            $home->assign('next1',$current_page);
        }
        // if ($limit == 5) {
        //     $stt = $_GET['page'];
        // }
        $sql= "SELECT  img FROM gallery LIMIT $start,$limit";
        $result = $db->fetchAll($sql);
        foreach($result as $val) {
            $home->insert_loop("GALLERY.IMG",array("LIST"=>$val));
            
        }
        $sql_album="SELECT * FROM album WHERE 1; ";
        $ar=$db->fetchAll($sql_album);
        foreach($ar as $album){
            $home->insert_loop("GALLERY.LIST_ALBUM",array("LIST_ALBUM"=>$album));


        }
    }




    $home->parse("GALLERY");
    $content = $home->text("GALLERY");

?>