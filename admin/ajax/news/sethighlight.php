<?php
include("../../../../project/libs/bootstrap.php");

        if(isset($_GET['id'])){
            $id_d=$_GET['id'];
            
            $sql_check="SELECT highlight FROM news WHERE id= $id_d ;";
            
            $ar=$db->fetchOne($sql_check);
            if($ar['highlight']==0){
                $sql ="UPDATE news SET highlight = 1 WHERE id = $id_d ;";
                $db->execSQL($sql);

            }else{
                $sql ="UPDATE news SET highlight = 0 WHERE id = $id_d ;";
                $db->execSQL($sql); 
            }
           
            

           
            
        }

        
        
        
    

