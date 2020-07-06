<?php
$td = new XTemplate("views/dogfaq/add.html");
$td->assign('baseUrl',$baseUrl);

if(
isset($_POST['txtQuestion'])&&
isset($_POST['txtAnswer']) 
){
    $Question           = trim($_POST['txtQuestion']);
    $Answer             = $_POST['txtAnswer'];    
        //chen thong tin vao bang news
        $sql            ="   INSERT INTO faq(title,answ)
                            VALUES 	('$Question ','$Answer');";  
        $db             ->execSQL($sql);

        $f              ->direction("?m=table&a=dogfaq");

} ; 

$td->parse('ADD');
$content = $td->text('ADD');