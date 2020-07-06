<?php
    if($permission!='admin'){
        echo"<script>alert('This account has not permission for this action')</script>";
        $f->direction("?m=table&a=dogfaq");        
    }else{
        if(isset($_GET['id'])){
            $id_d = $_GET['id'];
            //xoá 
            $sql ="DELETE FROM faq WHERE id = $id_d";
            $db->delete($sql);
        
            $f->direction("?m=table&a=dogfaq");
        }
        
        
        if(isset($_GET['lsid'])){
        
            //xoá
            $sql ="DELETE FROM faq WHERE id IN ($lsId);";
            $db->delete($sql);
            $f->direction("?m=table&a=dogfaq");
            
        }
    }