<?php
//test xoá ảnh không thành công
// $n='_1575768334_fdf.jpg';
// $filename="./".$n;
// unlink($filename);
if($permission!='admin'||$permission!='managerpro'){
    echo"<script>alert('This account has not permission for this action')</script>";
    $f->direction("?m=table&a=typedog");
    
}else{
    if(isset($_GET['id'])){
        $id_d = $_GET['id'];
        //xoá quan hệ dog_country
        $sql_delCountry=" DELETE FROM dogs_country WHERE id_dogs=$id_d;";
        $db->delete($sql_delCountry);
        //delete ảnh
        $sql_getImg= "SELECT img FROM dogs WHERE id = $id_d;";
        $img=$db->fetchOne($sql_getImg);
        $img_name=$img['img'];
        $filename="./img/".$img_name;
        unlink($filename);
        //xoá dog
        $sql_delDogs ="DELETE FROM dogs WHERE id = $id_d";
        $db->delete($sql_delDogs);
        $f->direction("?m=table&a=Typedog");
    }
    
    
    if(isset($_GET['lsid'])){
        $lsId = $_GET['lsid'];
        //xoá quan hệ dog_country
        $sql_del_d_c=" DELETE FROM dogs_country WHERE id_dogs IN ($lsId);";
        $db->delete($sql_del_d_c);
        //lấy ra ảnh
        $sql_getImg= "SELECT img FROM dogs WHERE id IN ($lsId);";
        $img=$db->fetchAll($sql_getImg);
        foreach($img as $arr){
            $img_name=$arr['img'];
            $filename="./img/".$img_name;
            unlink($filename);
        }
        //xoá dog
        $sql ="DELETE FROM dogs WHERE id IN ($lsId);";
        $db->delete($sql);
        $f->direction("?m=table&a=Typedog");
        
    }


}

    
