<?php
    if($permission!='admin'){
        echo"<script>alert('This account has not permission for this action')</script>";
        $f->direction("?m=table&a=contact");
        
    }else{
        if(isset($_GET['id'])){
            $id_d = $_GET['id'];
            //xoá 
            $sql ="DELETE FROM contact WHERE id = $id_d";
            $db->delete($sql);
            $f->direction("?m=table&a=contact");
        }
        
        
        if(isset($_GET['lsid'])){

            //xoá 
            $sql ="DELETE FROM contact WHERE id IN ($lsId);";
            $db->delete($sql);
            $f->direction("?m=table&a=contact");
            
        }
    }