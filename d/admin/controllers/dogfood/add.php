<?php
$td = new XTemplate("views/Dogfood/add.html");
$td->assign('baseUrl',$baseUrl);

$sql_getcategory ="SELECT id, catalogies FROM food_catalogies WHERE 1;";
$arr1 = $db->fetchAll($sql_getcategory); 
    foreach($arr1 as $c){
        $td->insert_loop("ADD.S_CATEGORY",array("S_CATEGORY"=>$c)); 
    }

$do_save=1;


if(isset($_POST['txtTitle'])){
    $title          = trim($_POST['txtTitle']);
    $catalogies         = $_POST['txtcatalogies'];
    $title2         = vn_to_str($title);
    $Subcontent    = $_POST['s_content'];
    $Fullcontent   = $_POST['f_content'];
    $foodprice         = $_POST['txtprice'];
    $foodorigin        = $_POST['txtorigin'];
    $file              = $_FILES['image_upload'];
    $NewImgName        = setNameImg($title);
    $img           = $f->uploadFile($file,$urlFile,$arExt,$maxSize,$NewImgName);
    
    if($img=="100"){
        $mess = "Invalid type of file";
        $td->assign('mess_img2',$mess);
        $td->assign('mess_img1',"Error:");
        $do_save = -1;
    }
    if($img=="101"){
        $mess = "File size must be under 3MB";
        $td->assign('mess_img2',$mess);
        $td->assign('mess_img1',"Error:");
        $do_save = -1;
    }
    if(empty($img)){
        $mess = "File upload Faile!";
        $td->assign('mess_img2',$mess);
        $td->assign('mess_img1',"Error:");
        $do_save = -1;
    }
    if($do_save==1){  
        //insert thông tin vào bảng food
        $sql1   ="INSERT INTO food(img, title,title_sign, subcontent, fullcontent, price, origin, id_cat)
                    VALUES 	('$img','$title','$title2','$Subcontent','$Fullcontent', '$foodprice', '$foodorigin', '$catalogies');";
        $db->execSQL($sql1);
        $f->direction("?m=table&a=Dogfood"); 
    }
} ; 

$td->parse('ADD');
    $content = $td->text('ADD');