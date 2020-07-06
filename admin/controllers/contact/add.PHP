<?php
$td = new XTemplate("views/contact/add.html");
$td->assign('baseUrl',$baseUrl);
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

        //chen thong tin vao bang news
    $sql1           ="  INSERT INTO contact(location,
                                            email, 
                                            phone,
                                            link_fb,
                                            link_ins,
                                            link_youtube,
                                            link_google)    
                        VALUES(             '$Location',
                                            '$Email',
                                            '$Phone',
                                            '$LkFacebook',
                                            '$LkInstagram',
                                            '$LkYoutube',
                                            '$LkGoogle');";
    
    $db->execSQL($sql1);

    $f->direction("?m=table&a=contact");
} ; 

$td->parse('ADD');
    $content = $td->text('ADD');