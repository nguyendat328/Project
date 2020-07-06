<?php

if($permission=='manager'){
    echo"<script>alert('This account has not permission for this action')</script>";
    $f->direction("?m=table&a=request");
    
}else{
    if(isset($_GET['id'])){
        $id_d = $_GET['id'];
        
        //xoá
        $sql_delDogs ="DELETE FROM cus_contact WHERE id = $id_d";
        $db->delete($sql_delDogs);
        $f->direction("?m=table&a=request");
    }
    
    
    if(isset($_GET['lsid'])){
        $lsId = $_GET['lsid'];
        
        //xoá dog
        $sql ="DELETE FROM cus_contact WHERE id IN ($lsId);";
        $db->delete($sql);
        $f->direction("?m=table&a=request");
        
    }


}

    
