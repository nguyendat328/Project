<?php
$td = new XTemplate("views/dognews/edit.html");
$td->assign('baseUrl',$baseUrl);

if(isset($_GET['id'])){
    $id_d=$_GET['id'];
    //lấy thông tin chó
    $sql_getnews    ="  SELECT *
                        FROM news 
                        WHERE id=$id_d;";
    $arrd           = $db->fetchOne($sql_getnews);
    //đẩy thông tin vào các trường
    if($arrd){
        $title      =$arrd['title'];
        $sub        =$arrd['subcontent'];
        $full       =$arrd['fullcontent'];
        $td         ->assign('title',$title);
        $td         ->assign('title_sign',$title2);
        $td         ->assign('subcontent',$sub);
        $td         ->assign('fullcontent',$full);
    }
}
// quá trình update
$do_save=1;

    if(isset($_POST['txtTitle'])){
        $newsTitle          = trim($_POST['txtTitle']);
        $title2            = vn_to_str($newsTitle);
        $newsSubcontent    = $_POST['s_content'];
        $newsFullcontent   = $_POST['f_content'];
        $file              = $_FILES['image_upload'];
        $NewImgName        = setNameImg($newstitle);
        $newsImg           = $f->uploadFile($file,$urlFile,$arExt,$maxSize,$NewImgName);
        
        if($file['error']==4){
            //update news
            $sql_upNews     ="  UPDATE news
                                SET title       ='$newsTitle',
                                    title_sign  ='$title2',
                                    subcontent  ='$newsSubcontent',
                                    fullcontent ='$newsFullcontent'
                                WHERE id        =$id_d;";
            $db->execSQL($sql_upNews);
        }else{
            if($newsImg=="100"){
                $mess = "Invalid type of file";
                $td->assign('mess_img2',$mess);
                $td->assign('mess_img1',"Error:");   
                $do_save = -1;
            }
            if($newsImg=="101"){
                $mess = "File size must be under 2MB";
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
                $sql_getImg = "SELECT img FROM news WHERE id = $id_d;";
                $img        =$db->fetchOne($sql_getImg);
                $img_name   =$img['img'];
                $filename   ="./img/".$img_name;
                unlink($filename);
                $sql_upNews="  UPDATE news
                SET 
                    img         ='$newsImg', 
                    title       ='$title',
                    title_sign  ='$title2',
                    subcontent  ='$newsSubcontent',
                    fullcontent ='$newsFullcontent'
                WHERE id        =$id_d;";
                $db->execSQL($sql_upNews);
 
            }
        }
    
        $f->direction("?m=table&a=dognews"); 
    };
   


$td->parse('EDIT');
    $content = $td->text('EDIT');