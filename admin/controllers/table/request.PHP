<?php
$td = new XTemplate("views/table/request.html");
$td->assign('baseUrl',$baseUrl);

//tìm ra limit
if(isset($_GET['limit'])){
    $tmp=$_GET['limit'];
    if($tmp==5||$tmp==10||$tmp==20){
        $limit =$tmp; 
        if($limit==5){
            $td->assign('select5',"selected");   
        }elseif($limit==10){
            $td->assign('select10',"selected");   
        }elseif($limit==20){
            $td->assign('select20',"selected");   
        }
    }else{
        $limit=5;
        $td->assign('select5',"selected");
    }
}else{
    $limit=5;
    $td->assign('select5',"selected");
}
    



//lấy tổng số bản ghi
$sql1="SELECT count(cus_name) AS t FROM cus_contact WHERE 1;";
$arr=$db->fetchOne($sql1);
$total=$arr['t'];
$td->assign('total',$total);
if($total==0){
$mes="Xin lỗi, Không có bản ghi nào được tìm thấy, vui lòng thử lại!";
    $td->assign('mess',$mes);
    $td->assign('s',0);
    $td->assign('nas',0);
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
    $td->assign('s',$s);
    $td->assign('nas',$sa);


    //chèn du lieu
    
    $sql="  SELECT  *              
            FROM    cus_contact
            
            LIMIT $start,$limit";
    $arr1 = $db->fetchAll($sql); 

         
    $i=1;

    ; 
    foreach($arr1 as $content){
        $content['i']=$i;
        if($content['response']==1){
            $td->assign('check','checked'); 
        }else{$td->assign('check','');}       
        $td->insert_loop("TABLE.CONTENT",array("CONTENT"=>$content));
        $i++;
    }
    //quy định nút prev
    if($current_page>1 && $total_page>1){
        $p=$current_page-1;
        $td->assign('next',"");  
        $td->assign('p',$p);
    }else{$td->assign('prev',"disabled");}

    //chèn phân trang
    for($i=1;$i<=$total_page;$i++){
        if($i==$current_page){
            $td->assign('active',"active");
            $td->assign('i',$i);
            $td->parse('TABLE.S_PAGE');
        }else{
            $td->assign('active',"");
            $td->assign('i',$i);  
            $td->parse('TABLE.S_PAGE');
        }
    }
    //quy định nút next
    if($current_page<$total_page && $total_page>1){
        $n=$current_page+1;
        $td->assign('next',"");
        $td->assign('n',$n);
    }else{$td->assign('next',"disabled");}
}


$td->parse('TABLE');
    $content = $td->text('TABLE');


