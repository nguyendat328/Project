<?php
include("../../../../project/libs/bootstrap.php");

        if(isset($_GET['id'])){
            $id_d=$_GET['id'];
            
            $sql_check="SELECT response FROM cus_contact WHERE id= $id_d ;";
            
            $ar=$db->fetchOne($sql_check);
            if($ar['response']==0){
                $sql ="UPDATE cus_contact SET response = 1 WHERE id = $id_d ;";
                $db->execSQL($sql);

            }else{
                $sql ="UPDATE cus_contact SET response = 0 WHERE id = $id_d ;";
                $db->execSQL($sql); 
            }
   
        }
        $sqlRead="SELECT COUNT(response) AS t FROM cus_contact WHERE response = 0;";
            $arr=$db->fetchOne($sqlRead);
            $total = $arr['t'];
        echo"No Response (". $total.")";

        
        
        
    

