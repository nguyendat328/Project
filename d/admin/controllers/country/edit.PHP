<?php
$td = new XTemplate("views/country/edit.html");
$td->assign('baseUrl',$baseUrl);

if(isset($_GET['id'])){
    $id_d=$_GET['id'];
    //lấy thông tin 
    $sql_getnews    ="  SELECT *
                        FROM country 
                        WHERE id=$id_d;";

    $arrd           = $db->fetchOne($sql_getnews);
    //đẩy thông tin vào các trường
    if($arrd){
        $country    =$arrd['countryname'];
        $sub        =$arrd['subcontent'];
        $full       =$arrd['fullcontent'];
        $td         ->assign('country',$country);
        $td         ->assign('subcontent',$sub);
        $td         ->assign('fullcontent',$full);
    }
}
// quá trình update
$do_save=1;

    if(isset($_POST['txtCountry'])){
        $newsCountry         = trim($_POST['txtCountry']);
        $newsSubcontent    = $_POST['s_content'];
        $newsFullcontent   = $_POST['f_content'];
        $file              = $_FILES['image_upload'];
        $NewImgName        = setNameImg($newsCountry);
        $countryImg        = $f->uploadFile($file,$urlFile,$arExt,$maxSize,$NewImgName);
        
        if($file['error']==4){
            //update news
            $sql_up    ="  UPDATE country
                                SET countryname ='$newsCountry',
                                    subcontent  ='$newsSubcontent',
                                    fullcontent ='$newsFullcontent'
                                WHERE id        =$id_d;";
            $db->execSQL($sql_up);
        }else{
            if($countryImg=="100"){
                $mess = "Invalid type of file";
                $td->assign('mess_img2',$mess);
                $td->assign('mess_img1',"Error:");   
                $do_save = -1;
            }
            if($countryImg=="101"){
                $mess = "File size must be under 2MB";
                $td->assign('mess_img2',$mess);
                $td->assign('mess_img1',"Error:");
                $do_save = -1;
            }
            if(empty($countryImg)){
                $mess = "File upload Faile!";
                $td->assign('mess_img2',$mess);
                $td->assign('mess_img1',"Error:");
                $do_save = -1;
            }
            if($do_save==1){
                $sql_getImg = "SELECT img FROM country WHERE id = $id_d;";
                $img        =$db->fetchOne($sql_getImg);
                $img_name   =$img['img'];
                $filename   ="./img/".$img_name;
                unlink($filename);
                $sql_up="  UPDATE country
                SET 
                    img         ='$countryImg', 
                    countryname ='$newsCountry',
                    subcontent  ='$newsSubcontent',
                    fullcontent ='$newsFullcontent'
                WHERE id        =$id_d;";
                $db->execSQL($sql_up);
 
            }
        }
    
        $f->direction("?m=table&a=country"); 
    };
   


$td->parse('EDIT');
    $content = $td->text('EDIT');