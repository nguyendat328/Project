<?php
    $home = new XTemplate("views/tables/countrys.html");
    $home->assign('baseUrl',$baseUrl);
    $pagetitle = "Patrona - Country Page";

    $hxtp->assign('pagetitle',$pagetitle);
    $limit = 12;

    $condition = 1;
    if (isset($_REQUEST['btn-search'])) {
        $key = addslashes($_GET['countrySearch']);

        if (empty($key)) {
            echo "Yeu cau nhap du lieu vao o trong";
        } else {
            $kw = str_replace(' ','%',$key);
            $condition  = "countryname LIKE '%$kw%' "; 
        }
    }
    
    $sql1 = "SELECT id FROM country where $condition";
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
                $home->parse('COUNTRY.PAGE');
            }else{
                $home->assign('active',"");
                $home->assign('i',$i);  
                $home->parse('COUNTRY.PAGE');
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
        $sql= "SELECT countryname, subcontent, id, img FROM country where $condition LIMIT $start,$limit";
        $result = $db->fetchAll($sql);
        foreach($result as $val) {
            $home->assign('LIST',$val);
            $home->parse('COUNTRY.quocgia');
            $i++;
            
        }
    }


    $home->parse("COUNTRY");
    $content = $home->text("COUNTRY");

?>