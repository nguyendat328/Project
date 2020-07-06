<?php
if($permission!='admin'){
    echo"<script>alert('This account has not permission for this action')</script>";
    $f->direction("?m=table&a=Dogfood");
    
}else{
    if(isset($_GET['id'])){
        $id_d = $_GET['id'];
        $sql_del=" DELETE FROM food WHERE id=$id_d;";
        $sql_find_img=" SELECT img FROM food WHERE id=$id_d;";
        $arr3 = $db->fetchOne($sql_find_img); 
        $img_name=$arr3['img'];
        $filename="./img/".$img_name;
        unlink($filename);
        $db->delete($sql_del);
        $f->direction("?m=table&a=Dogfood");
    }
    
    
	if(isset($_GET['lsid'])){
        $lsId = $_GET['lsid'];
        //lấy ra ảnh
        $sql_getImg= "SELECT img FROM food WHERE id IN ($lsId);";
        $img=$db->fetchAll($sql_getImg);
        foreach($img as $arr){
            $img_name=$arr['img'];
            $filename="./img/".$img_name;
            unlink($filename);
        }
        //xoá food
        $sql ="DELETE FROM food WHERE id IN ($lsId);";
        $db->delete($sql);
        $f->direction("?m=table&a=Dogfood");
		
    } 
}
   