<?php
$td = new XTemplate("views/typedog/add.html");
$td->assign('baseUrl',$baseUrl);

$sql_getcountry="SELECT country.id, country.countryname FROM country WHERE 1;";
$arr2 = $db->fetchAll($sql_getcountry); 
    foreach($arr2 as $c){
        $td->insert_loop("ADD.S_COUNTRY",array("S_COUNTRY"=>$c));
        
    }

$do_save=1;


if(
isset($_POST['txtName']) 
){
    $dogsName          = trim($_POST['txtName']);
    $title2            = set_Str_NoSign($dogsName);
    $dogsCountryid     = $_POST['txtCountry'];
    $dogsSubcontent    = $_POST['s_content'];
    $dogsFullcontent   = $_POST['f_content']; 
    $file              = $_FILES['image_upload'];
    $NewImgName        = set_Str_NoSign($dogsName);
    $dogsImg           = $f->uploadFile($file,$urlFile,$arExt,$maxSize,$NewImgName);
    
    if($dogsImg=="100"){
        $mess = "Invalid type of file";
        $td->assign('mess_img2',$mess);
        $td->assign('mess_img1',"Error:");
       

        $do_save = -1;
    }
    if($dogsImg=="101"){
        $mess = "File size must be under 2MB";
        $td->assign('mess_img2',$mess);
        $td->assign('mess_img1',"Error:");
        $do_save = -1;
    }
    if(empty($dogsImg)){
        $mess = "File upload Faile!";
        $td->assign('mess_img2',$mess);
        $td->assign('mess_img1',"Error:");
        $do_save = -1;
    }
    if($do_save==1){
        
        //chen thong tin vao bang chó
        $sql1   ="INSERT INTO dogs(img,dog_name,subcontent,fullcontent,title_sign,highlight)
                    VALUES 	('$dogsImg','$dogsName','$dogsSubcontent','$dogsFullcontent','$title2',0);";
        $dog_id = getlastID($db,$sql1);//lấy ra id  chó mới chèn vào
        //chèn thông tin tham chiếu  bảng chó_qg
        $sql1_1 ="INSERT INTO dogs_country(id_dogs,id_country) 
                    VALUES	('$dog_id','$dogsCountryid');";
        $db->execSQL($sql1_1);

            $f->direction("?m=table&a=Typedog");
        
    }




} ; 

$td->parse('ADD');
    $content = $td->text('ADD');