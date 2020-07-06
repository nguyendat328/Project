<?php
    if($permission!='admin'||$permission!='managerpro'){
        echo"<script>alert('This account has not permission for this action')</script>";
        $f->direction("?m=table&a=dognews");
        
    }else{
        if(isset($_GET['id'])){
            $id_d = $_GET['id'];
            //delete ảnh
            $sql_getImg= "SELECT img FROM news WHERE id = $id_d;";
            $img=$db->fetchOne($sql_getImg);
            $img_name=$img['img'];
            $filename="./img/".$img_name;
            unlink($filename);
            //xoá news
            $sql_delNews ="DELETE FROM news WHERE id = $id_d";
            $db->delete($sql_delNews);
            $f->direction("?m=table&a=dognews");
        }
        
        
        if(isset($_GET['lsid'])){
            //lấy rah
            $sql_getImg= "SELECT img FROM news WHERE id IN ($lsId);";
            $img=$db->fetchAll($sql_getImg);
            foreach($img as $arr){
                $img_name=$arr['img'];
                $filename="./img/".$img_name;
                unlink($filename);
            }
            //xoá 
            $sql ="DELETE FROM news WHERE id IN ($lsId);";
            $db->delete($sql);
            $f->direction("?m=table&a=dognews");
            
        }
    
        
    }

