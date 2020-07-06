<?php
   if($permission!='admin'||$permission!='managerpro'){
    echo"<script>alert('This account has not permission for this action')</script>";
    $f->direction("?m=table&a=album");
    
}else{   
    if(isset($_GET['id'])){
        $id_d = $_GET['id'];
        //lấy ra id gallery
        $sql_getidGal="SELECT id_gallery FROM gallery_album WHERE id_album=$id_d;";
        $arrg= $db->fetchAll($sql_getidGal);
        //xoá quan hệ 
        $sql_del="DELETE FROM gallery_album WHERE id_album=$id_d;";
        $db->delete($sql_del);
        //delete album
        $sql_delalbum=" DELETE FROM album WHERE id=$id_d;";
        $db->delete($sql_delalbum);
        //xoá 
        foreach($arrg as $arrImg){
            $idImg= $arrImg['id_gallery'];
            //xoá ảnh trong thu muc
            $sql_getImg= "SELECT img FROM gallery WHERE id = $idImg;";
            $img=$db->fetchOne($sql_getImg);
            $img_name=$img['img'];
            $filename="./img/".$img_name;
            unlink($filename);
            //xoá gallery
            $sql_delgal ="DELETE FROM gallery WHERE id = $idImg";
            $db->delete($sql_delgal);
        }
        
        
        $f->direction("?m=table&a=album");
    }
    
    
	if(isset($_GET['lsid'])){
        $lsId = $_GET['lsid'];
        //lấy ra id gallery
        $sql_getidGal="SELECT id_gallery FROM gallery_album WHERE id_album IN ($lsId);";
        $arrg= $db->fetchAll($sql_getidGal);
        //xoá quan hệ 
        $sql_del="DELETE FROM gallery_album WHERE id_album IN ($lsId);";
        $db->delete($sql_del);
        //delete album
        $sql_delalbum=" DELETE FROM album WHERE id IN ($lsId);";
        $db->delete($sql_delalbum);
        //xoa
        foreach($arrg as $arrImg){
            $idImg= $arrImg['id_gallery'];
            //xoá ảnh trong thu muc
            $sql_getImg= "SELECT img FROM gallery WHERE id = $idImg;";
            $img=$db->fetchOne($sql_getImg);
            $img_name=$img['img'];
            $filename="./img/".$img_name;
            unlink($filename);
            //xoá gallery
            $sql_delgal ="DELETE FROM gallery WHERE id = $idImg";
            $db->delete($sql_delgal);
        }
        
        $f->direction("?m=table&a=album");
		
    }
}