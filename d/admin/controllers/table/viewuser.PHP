<?php
$td = new XTemplate("views/table/viewuser.html");
$td->assign('baseUrl',$baseUrl);

if(isset($_GET['id'])){
    $id_u=$_GET['id'];
    
    $sql="  SELECT  *             
    FROM    account
    WHERE id= $id_u;";
   

    $arr1 = $db->fetchOne($sql);  
    $i=1;
    $username = $arr1['username'];
    $img = $arr1['img'];
    if(isset($arr1['permission'])){
        $per = $arr1['permission'];
    }else{$per ="";}
    
    $email = $arr1['email'];
    
    switch($per){
        case 'admin':{
            $deltai='Do anything but not delete Admin Account';
            break;
        }
        case 'managerpro':{
            $deltai='Insert, Edit, Delete Data';
            break;
        }
        case 'manager':{
            $deltai='Insert, Edit Data';
            break;
        }
        case '':{
            $deltai='';
            break;
        }
    }
    $td->assign('i',$i);
    $td->assign('id',$id_u);
    $td->assign('img',$img);
    $td->assign('username',$username);
    $td->assign('permission',$per);
    $td->assign('detail',$deltai);
    $td->assign('email',$email);





    
    




}

    
    



$td->parse('TABLE');
    $content = $td->text('TABLE');


