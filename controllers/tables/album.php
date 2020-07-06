<?php
    $home = new XTemplate("views/tables/album.html");
    $home->assign('baseUrl',$baseUrl);
    $pagetitle = "Patrona - Gallery Page";

    $hxtp->assign('pagetitle',$pagetitle);
    $limit = 8;
if(isset($_GET['ida'])){
    $id_a=$_GET['ida'];
    $home->assign('id',$id_a);
    $sql1 = "SELECT count(a.id) AS t
                FROM gallery AS a, gallery_album AS b,album AS c 
                WHERE a.id=b.id_gallery AND c.id=b.id_album AND c.id= $id_a";
    $rs = $db->fetchOne($sql1);
    $total_records = $rs['t'];
    
    if ($total_records==0) {
        $mes = "This Album have not image. Please choose another album.!";
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
                $home->parse('ALBUM.PAGE');
            }else{
                $home->assign('active',"");
                $home->assign('i',$i);  
                $home->parse('ALBUM.PAGE');
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
        // dat ten link
        $sqla= "SELECT album
                FROM album 
                WHERE  id= $id_a ";
        $re = $db->fetchOne($sqla);
        $album_name = $re['album'];
       
        $home->assign('album_name',$album_name);

        //list album
        $sql_album="SELECT * FROM album WHERE 1; ";
        $ar=$db->fetchAll($sql_album);
        foreach($ar as $album){
            $home->insert_loop("ALBUM.LIST_ALBUM",array("LIST_ALBUM"=>$album));


        }
        //list img
        $sql= "SELECT a.id, a.img, a.caption
                FROM gallery AS a, gallery_album AS b,album AS c 
                WHERE a.id=b.id_gallery AND c.id=b.id_album AND c.id= $id_a LIMIT $start,$limit";
        $result = $db->fetchAll($sql);
        foreach($result as $val) {
            $home->insert_loop("ALBUM.IMG",array("LIST"=>$val));
            
        }
        
    }
}else{
    $f->direction("?m=tables&a=gallery");
}




    $home->parse("ALBUM");
    $content = $home->text("ALBUM");

?>