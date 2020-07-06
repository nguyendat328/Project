<?php
$td = new XTemplate("views/dogfaq/edit.html");
$td->assign('baseUrl',$baseUrl);

if(isset($_GET['id'])){
    $id_d=$_GET['id'];
    //lấy thông tin
    $sql_getnews    ="  SELECT title,answ
                        FROM faq 
                        WHERE id=$id_d;";

    $arrd           = $db->fetchOne($sql_getnews);
    //đẩy thông tin vào các trường
    if($arrd){  
        $Question   =$arrd['title'];
        $Answer     =$arrd['answ']; 
        $td         ->assign('Question',$Question);
        $td         ->assign('Answer',$Answer);

    }
}
// quá trình update


    if(isset($_POST['txtQuestion'])){
        $newsTitle          = trim($_POST['txtQuestion']);
        $newsFullcontent    = $_POST['txtAnswer'];

        $sql_upFaq          ="  UPDATE  faq
                                SET 
                                        title   ='$Question',
                                        answ    ='$Answer'
                                WHERE   id      =$id_d;";
        $db->execSQL($sql_upFaq);
 
            
        
    
        $f->direction("?m=table&a=dogfaq"); 
    };
   


$td->parse('EDIT');
    $content = $td->text('EDIT');