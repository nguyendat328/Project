<?php
    include("../libs/bootstrap.php");  
    
//BEGIN------------------------in ra DOGS hight light------------------------------------------------------------//
 $name       =$_POST['CustomerName'];  
 $email      =$_POST['CustomerEmail'];
 $phone      =$_POST['CustomerPhone'];
 $content    =$_POST['CustomerContent'];
 $date       = date("Y/m/d");

 $sql      ="INSERT INTO cus_contact(cus_name,cus_email,cus_phone,cus_content,date_up,response)
                 VALUES('$name','$email','$phone','$content','$date',0);";
$db->execSQL($sql);
//-------------------------------------------------------------------------------//
