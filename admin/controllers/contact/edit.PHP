<?php
$td = new XTemplate("views/contact/edit.html");
$td->assign('baseUrl',$baseUrl);

if(isset($_GET['id'])){
    $id_d=$_GET['id'];
    //lấy thông tin chó, country,picture
    //chó
    $sql_get    ="  SELECT *
                        FROM contact
                        WHERE id=$id_d;";

    $arrd           = $db->fetchOne($sql_get);
    //đẩy thông tin vào các trường
    if($arrd){
        $Location       = $arrd['location'];
        $Email          = $arrd['email'];
        $Phone          = $arrd['phone'];
        $LkFacebook     = $arrd['link_fb'];
        $LkInstagram    = $arrd['link_ins'];
        $LkYoutube      = $arrd['link_youtube'];
        $LkGoogle       = $arrd['link_google'];
        $td         ->assign('Location',$Location);
        $td         ->assign('Email',$Email);
        $td         ->assign('Phone',$Phone);
        $td         ->assign('LkFacebook',$LkFacebook);
        $td         ->assign('LkInstagram',$LkInstagram);
        $td         ->assign('LkYoutube',$LkYoutube);
        $td         ->assign('LkGoogle',$LkGoogle);

    }
}

if(
    isset($_POST['txtLocation'])&&
    isset($_POST['txtEmail'])&&
    isset($_POST['txtPhone']) 
    ){
        $Location       = trim($_POST['txtLocation']);
        $Email          = trim($_POST['txtEmail']);
        $Phone          = trim($_POST['txtPhone']);
        $LkFacebook     = $_POST['txtFb'];
        $LkInstagram    = $_POST['txtIns'];
        $LkYoutube      = $_POST['txtYoutube'];
        $LkGoogle       = $_POST['txtGoogle'];
       
        $sql1           ="  UPDATE  contact
                            SET     Location='$Location',
                                    Email='$Email', 
                                    Phone='$Phone',
                                    link_fb='$LkFacebook',
                                    link_ins='$LkInstagram',
                                    link_youtube='$LkYoutube',
                                    link_google ='$LkGoogle'  
                            WHERE id=$id_d;";

$db->execSQL($sql1);
            
        
    
        $f->direction("?m=table&a=contact"); 
    };
   


$td->parse('EDIT');
    $content = $td->text('EDIT');