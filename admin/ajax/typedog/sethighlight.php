<?php
include("../../../../project/libs/bootstrap.php");

        if(isset($_GET['id'])){
            $id_d=$_GET['id'];
            
            $sql_check="SELECT highlight FROM dogs WHERE id= $id_d ;";
            
            $ar=$db->fetchOne($sql_check);
            if($ar['highlight']==0){
                $sql ="UPDATE dogs SET highlight = 1 WHERE id = $id_d ;";
                $db->execSQL($sql);

            }else{
                $sql ="UPDATE dogs SET highlight = 0 WHERE id = $id_d ;";
                $db->execSQL($sql); 
            }
   
        }
        $sqlRead="SELECT COUNT(highlight) AS t FROM dogs WHERE highlight = 1;";
            $arr=$db->fetchOne($sqlRead);
            $total = $arr['t'];
        echo"Highlight (<span color='red'!important>". $total."</span>)";

        
        
        
    

