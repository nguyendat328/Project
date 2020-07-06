<?php
$td = new XTemplate("views/dognews/add.html");
$td->assign('baseUrl',$baseUrl);

$do_save=1;
 

if(
isset($_POST['txtTitle']) 
){
    $newstitle         = trim($_POST['txtTitle']);
    $title2            = vn_to_str($newstitle);
    $newsSubcontent    = $_POST['s_content'];
    $newsFullcontent   = $_POST['f_content'];
    $file              = $_FILES['image_upload'];
    $NewImgName        = setNameImg($newstitle);
    $newsImg           = $f->uploadFile($file,$urlFile,$arExt,$maxSize,$NewImgName);

    if($newsImg=="100"){
        $mess = "Invalid type of file";
        $td->assign('mess_img2',$mess);
        $td->assign('mess_img1',"Error:");
        $do_save = -1;
    }
    if($newsImg=="101"){
        $mess = "File size must be under 3MB";
        $td->assign('mess_img2',$mess);
        $td->assign('mess_img1',"Error:");
        $do_save = -1;
    }
    if(empty($newsImg)){
        $mess = "File upload Faile!";
        $td->assign('mess_img2',$mess);
        $td->assign('mess_img1',"Error:");
        $do_save = -1;
    }
    if($do_save==1){
        
        //chen thong tin vao bang news
        $sql1   ="INSERT INTO news(img,title,title_sign,subcontent,fullcontent)
                    VALUES 	('$newsImg','$newstitle','$title2','$newsSubcontent','$newsFullcontent');";
    
        $db->execSQL($sql1);
            $f->direction("?m=table&a=dognews");
        
    }
} ; 

$td->parse('ADD');
    $content = $td->text('ADD');