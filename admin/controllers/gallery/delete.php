<?php
  if($permission=='manager'){
    echo"<script>alert('This account has not permission for this action')</script>";
    $f->direction("?m=table&a=gallery");
    
}else{
    if(isset($_GET['id'])){
        $id_d = $_GET['id'];
        //xoá quan hệ dog_country
        $sql_del=" DELETE FROM gallery_album WHERE id_gallery=$id_d;";
        $db->delete($sql_del);
        //delete ảnh
        $sql_getImg= "SELECT img FROM gallery WHERE id = $id_d;";
        $img=$db->fetchOne($sql_getImg);
        $img_name=$img['img'];
        $filename="./img/".$img_name;
        unlink($filename);
        //xoá 
        $sql_delg ="DELETE FROM gallery WHERE id = $id_d";
        $db->delete($sql_delg);
        $f->direction("?m=table&a=gallery");
    }
    
    
	if(isset($_GET['lsid'])){
        $lsId = $_GET['lsid'];
        //xoá quan hệ 
        $sql_dela=" DELETE FROM gallery_album WHERE id_gallery IN ($lsId);";
        $db->delete($sql_dela);
        //lấy ra ảnh
        $sql_getImg= "SELECT img FROM gallery WHERE id IN ($lsId);";
        $img=$db->fetchAll($sql_getImg);
        foreach($img as $arr){
            $img_name=$arr['img'];
            $filename="./img/".$img_name;
            unlink($filename);
        }
        //xoá dog
        $sql ="DELETE FROM gallery WHERE id IN ($lsId);";
        $db->delete($sql);
        $f->direction("?m=table&a=gallery");
		
    }
}