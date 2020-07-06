<?php
if($permission!='admin'){   
    $f->direction("?m=table&a=account");
    
}else{
    if(isset($_GET['id'])){
        $id_d = $_GET['id'];
        $sql_get    ="  SELECT *
                        FROM account 
                        WHERE id=$id_d;";    
        $arrd = $db->fetchOne($sql_get); 
        $per  =$arrd['permission'];
        if($per=='admin'){
 
            $f->direction("?m=table&a=account&u=$per");
        }else{
            //delete ảnh
            $sql_getImg= "SELECT img FROM account WHERE id = $id_d;";
            $img=$db->fetchOne($sql_getImg);
            $img_name=$img['img'];
            $filename="./img/".$img_name;
            unlink($filename);

            $sql_del=" DELETE FROM account WHERE id=$id_d;";
            $db->delete($sql_del);
            
            
        
            $f->direction("?m=table&a=account");

        }
         
    }
    
    
    if(isset($_GET['lsid'])){
        $lsId = $_GET['lsid'];
        $sql_get    ="  SELECT *
                        FROM account 
                        WHERE id IN ($lsId);";    
        $arrd = $db->fetchaLL($sql_get); 
        
        $k=0;
        foreach($arrd as $pr){
            if($pr['permission']=='admin'){
                $k=1;
                $per='admin'; 
            break;
            }else{
                $k=0;
            }
        }
       
        if($k==1){
            
            $f->direction("?m=table&a=account&u=$per");
        }else{
            $sql_getImg= "SELECT img FROM account WHERE id IN ($lsId);";
            $img=$db->fetchAll($sql_getImg);
            foreach($img as $arr){
                $img_name=$arr['img'];
                $filename="./img/".$img_name;
                unlink($filename);
            }
            //xoá 
            $sql ="DELETE FROM account WHERE id IN ($lsId);";
            $db->delete($sql);
            $f->direction("?m=table&a=account");
            

        }
    }
    
}


    
