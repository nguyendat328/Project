<?php
$td = new XTemplate("views/dognews/add.html");
$td->assign('baseUrl',$baseUrl);

$do_save=1;
 

if(
isset($_POST['txtTitle']) 
){
    $newstitle         = trim($_POST['txtTitle']);
    $title2            = set_Str_NoSign($newstitle);
    $newsSubcontent    = $_POST['s_content'];
    $newsFullcontent   = $_POST['f_content'];
    $date              = date("Y/m/d");
    $file              = $_FILES['image_upload'];
    $NewImgName        = set_Str_NoSign($newstitle);
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
        $sql1   ="INSERT INTO news(img,title,title_sign,subcontent,fullcontent,date_up,highlight)
                    VALUES 	('$newsImg','$newstitle','$title2','$newsSubcontent','$newsFullcontent','$date',0);";
    
        $db->execSQL($sql1);
            $f->direction("?m=table&a=dognews");
        
    }
} ; 

$td->parse('ADD');
    $content = $td->text('ADD');