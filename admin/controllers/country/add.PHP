<?php
$td = new XTemplate("views/country/add.html");
$td->assign('baseUrl',$baseUrl);

$do_save=1;
 

if(
isset($_POST['txtCountry'])
){
    $country            = trim($_POST['txtCountry']);
    $titleNoSign        = set_Str_NoSign($country);
    $Subcontent         = $_POST['s_content'];
    $Fullcontent        = $_POST['f_content'];
    $file               = $_FILES['image_upload'];
    $NewImgName         = set_Str_NoSign($country);
    $countryImg         = $f->uploadFile($file,$urlFile,$arExt,$maxSize,$NewImgName);

    if($countryImg=="100"){
        $mess = "Invalid type of file";
        $td->assign('mess_img2',$mess);
        $td->assign('mess_img1',"Error:");
        $do_save = -1;
    }
    if($countryImg=="101"){
        $mess = "File size must be under 3MB";
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
        
        //chen thong tin vao bang news
        $sql1   ="INSERT INTO country(countryname,img,subcontent,fullcontent,title_sign)
                    VALUES 	('$country','$countryImg','$Subcontent','$Fullcontent,'$titleNoSign');";
    
        $db->execSQL($sql1);
            $f->direction("?m=table&a=country");
        
    }




} ; 

$td->parse('ADD');
    $content = $td->text('ADD');