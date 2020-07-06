<?php
    $home = new XTemplate("views/tables/news.html");
    $home->assign('baseUrl',$baseUrl);
    $pagetitle = "Patrona - News Page";

    $hxtp->assign('pagetitle',$pagetitle);
    $limit = 6;
    $condition = 1;
    if (isset($_REQUEST['search'])) {
        $key = addslashes($_GET['Search']);

        if (empty($key)) {
            
        } else {
            
            $kw = str_replace(' ','%',$key);
            $condition  = "title LIKE '%$kw%' "; 
        }
    }
    if (isset($_GET['tin'])) {
        $new = $_GET['tin'];
        
        if ($new== 1) {
            $home->assign('highlight', 'active1');
            $home->assign('news', 'Highlight');
            $url_id = "&tin=1";
            $home->assign('tin',$url_id);


            $sql1 = "SELECT id FROM news where $condition and highlight = 1";
            $rs = $db->fetchAll($sql1);
            $total_records = count($rs);
            // var_dump ($total_records);die;
            if ($total_records==0) {
                $mes = "Không tìm thấy bản ghi!";
                $home->assign('mes', $mes);
                // echo "sadasld";die;

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
                        $home->parse('NEWS.PAGE');
                    }else{
                        $home->assign('active',"");
                        $home->assign('i',$i);  
                        $home->parse('NEWS.PAGE');
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
                $sql= "SELECT * FROM news where $condition and highlight = 1 ORDER BY RAND() LIMIT $start,$limit;";
                $result = $db->fetchAll($sql);
                foreach($result as $val) {
                    $home->assign('LIST',$val);
                    $home->parse('NEWS.news');
                    $i++;
                    
                }
                // echo "sadasld";
            } 
        } elseif ($new == 0) {
            $home->assign('update', 'active1');
            $home->assign('news', 'New Update');
            $url_id = "&tin=0";
            $home->assign('tin',$url_id);

            $query = "SELECT * FROM news WHERE date_up BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW();";
            $rs = $db->fetchAll($query);
            $total_records = count($rs);
            
            // var_dump ($total_records);die;
            if ($total_records==0) {
                $mes = "Không tìm thấy bản ghi!";
                $home->assign('mes', $mes);
                // echo "sadasld";die;

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
                        $home->parse('NEWS.PAGE');
                    }else{
                        $home->assign('active',"");
                        $home->assign('i',$i);  
                        $home->parse('NEWS.PAGE');
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
                
                $sql= "SELECT * FROM news WHERE date_up BETWEEN DATE_SUB(NOW(), INTERVAL 7 DAY) AND NOW() ORDER BY RAND() LIMIT $start,$limit;";
                $result = $db->fetchAll($sql);
                foreach($result as $val) {
                    $home->assign('LIST',$val);
                    $home->parse('NEWS.news');
                    $i++;
                    
                }
                
            } 
        }
        

    } else {

        $sql1 = "SELECT id FROM news where $condition ";
        $rs = $db->fetchAll($sql1);
        $total_records = count($rs);
        // var_dump ($total_records);die;
        if ($total_records==0) {
            $mes = "Không tìm thấy bản ghi!";
            $home->assign('mes', $mes);
            // echo "sadasld";die;

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
                    $home->parse('NEWS.PAGE');
                }else{
                    $home->assign('active',"");
                    $home->assign('i',$i);  
                    $home->parse('NEWS.PAGE');
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
            $sql= "SELECT * FROM news where $condition order by rand() LIMIT $start,$limit";
            $result = $db->fetchAll($sql);
            foreach($result as $val) {
                $home->assign('LIST',$val);
                $home->parse('NEWS.news');
                $i++;
                
            }
        }
    }
    

    

    
    
    



    $home->parse("NEWS");
    $content = $home->text("NEWS");

?>