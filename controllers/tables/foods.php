<?php
    $home = new XTemplate("views/tables/foods.html");
    $home->assign('baseUrl',$baseUrl);
    $pagetitle = "Patrona - Foods Page";

    $hxtp->assign('pagetitle',$pagetitle);

    $condition='1';
    $limit = 12;
    $url_id = "";
    $sql        = "SELECT * FROM food_catalogies WHERE 1";
    $arr        = $db->fetchAll($sql); 
    $i=0;
    foreach($arr as $content){
        
        $home->insert_loop('FOOD.CATEGORY',array("CATEGORY"=>$content));
        
    }
    $kw='';
    if(!empty($_POST['search'])){
        $keyword = $_POST['search'];
        if(strlen($keyword)>0){
           
            $kw = str_replace(' ','%',$keyword);
           $condition  =" title LIKE '%$kw%' "; 
        }
    }

    if(isset($_GET['id'])){
        $klm="<i class='fa fa-angle-right mr-3' aria-hidden='true' ></i>";
        $id_f = $_GET['id'];
        $url_id = "&id=".$id_f;
        $home->assign('id_f',$url_id);
        $sqlc        = "SELECT * FROM food_catalogies WHERE id=$id_f;";
        $arrc        = $db->fetchOne($sqlc); 
        
        $klm="<i class='fa fa-angle-right mr-3' aria-hidden='true' ></i><a href='#' class='mr-3'>".$kw."</a>";
        if($condition=='1'){
            $home->assign('catagory',$arrc['catalogies']);

        }else{
           $home->assign('catagory',$arrc['catalogies']);
            $home->assign('but',$klm);
            //$home->assign('catagory',$kw);
        }

        //lấy tổng số bản ghi
        $sql1="SELECT count(food.id) AS t FROM food WHERE food.id_cat = $id_f AND $condition;";
        $arr=$db->fetchOne($sql1);
        $total=$arr['t'];
        $home->assign('total',$total);
        if($total==0){
        $mes="Xin lỗi, Không có bản ghi nào được tìm thấy, vui lòng thử lại!!";
            $home->assign('mess',$mes);
            $home->assign('s',0);
            $home->assign('nas',0);
        }else{
            //tìm curent_page
            $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
           
            //tính số trang
            $total_page=ceil($total/$limit);
            if($current_page>$total_page){
                $current_page=$total_page;
            }else if($current_page<1){
                $current_page=1;
            }
            //tinh trang khoi dau
            $start=($current_page-1)*$limit;
            $s=$start+1;
            
            $sa=($s+$limit)-1;
            if($sa>=$total){
                $sa=$total;
            }
            //điền dòng hiển thị
            $home->assign('s',$s);
            $home->assign('nas',$sa);
        
        
            //chèn du lieu
            $sql="  SELECT  *
                    FROM    food
                    WHERE  food.id_cat = $id_f
                    AND $condition
                    LIMIT $start,$limit";
            $arr1 = $db->fetchAll($sql); 
            $i=1;
        
            foreach($arr1 as $content){
                $content['i']=$i;
                $home->insert_loop("FOOD.DETAIL",array("DETAIL"=>$content));
                $i++;
            }
            //quy định nút prev
            if($current_page>1 && $total_page>1){
                $p=$current_page-1;
                $home->assign('next',"");  
                $home->assign('p',$p);
            }else{$home->assign('prev',"disabled");}
        
            //chèn phân trang
            for($i=1;$i<=$total_page;$i++){
                if($i==$current_page){
                    $home->assign('active',"active");
                    $home->assign('i',$i);
                    $home->parse('FOOD.S_PAGE');
                }else{
                    $home->assign('active',"");
                    $home->assign('i',$i);  
                    $home->parse('FOOD.S_PAGE');
                }
            }
            //quy định nút next
            if($current_page<$total_page && $total_page>1){
                $n=$current_page+1;
                $home->assign('next',"");
                $home->assign('n',$n);
            }else{$home->assign('next',"disabled");}
        }
        
    }else{
         //lấy tổng số bản ghi
         $sql1="SELECT count(food.id) AS t FROM food WHERE 1 AND $condition;";
         $arr=$db->fetchOne($sql1);
         $total=$arr['t'];
         $home->assign('total',$total);
         if($condition!='1'){
            $home->assign('catagory',$kw);

        };
            
        
         if($total==0){
         $mes="Xin lỗi, Không có bản ghi nào được tìm thấy, vui lòng thử lại!!";
             $home->assign('mess',$mes);
             $home->assign('s',0);
             $home->assign('nas',0);
         }else{
             //tìm curent_page
             $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
            
             //tính số trang
             $total_page=ceil($total/$limit);
             if($current_page>$total_page){
                 $current_page=$total_page;
             }else if($current_page<1){
                 $current_page=1;
             }
             //tinh trang khoi dau
             $start=($current_page-1)*$limit;
             $s=$start+1;
             
             $sa=($s+$limit)-1;
             if($sa>=$total){
                 $sa=$total;
             }
             //điền dòng hiển thị
             $home->assign('s',$s);
             $home->assign('nas',$sa);
         
         
             //chèn du lieu
             $sql="  SELECT  food.id, food.img, food.title
                     FROM    food
                     WHERE  1
                     AND $condition
                     LIMIT $start,$limit";
             $arr1 = $db->fetchAll($sql); 
             $i=1;
         
             foreach($arr1 as $content){
                 $content['i']=$i;
                 $home->insert_loop("FOOD.DETAIL",array("DETAIL"=>$content));
                 $i++;
             }
             //quy định nút prev
             if($current_page>1 && $total_page>1){
                 $p=$current_page-1;
                 $home->assign('next',"");  
                 $home->assign('p',$p);
             }else{$home->assign('prev',"disabled");}
         
             //chèn phân trang
             for($i=1;$i<=$total_page;$i++){
                 if($i==$current_page){
                     $home->assign('active',"list-active");
                     $home->assign('i',$i);
                     $home->parse('FOOD.S_PAGE');
                 }else{
                     $home->assign('active',"");
                     $home->assign('i',$i);  
                     $home->parse('FOOD.S_PAGE');
                 }
             }
             //quy định nút next
             if($current_page<$total_page && $total_page>1){
                 $n=$current_page+1;
                 $home->assign('next',"");
                 $home->assign('n',$n);
             }else{$home->assign('next',"disabled");}
         }
    }
    



    $home->parse("FOOD");
    $content = $home->text("FOOD");
?>