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
isset($_POST['txtName'])&&
isset($_POST['txtCountry'])&&
isset($_POST['s_content'])&&
isset($_POST['f_content']) 
){
    $dogsName          = trim($_POST['txtName']);
    $dogsCountryid     = $_POST['txtCountry'];
    $dogsSubcontent    = $_POST['s_content'];
    $dogsFullcontent   = $_POST['f_content']; 
    $file              = $_FILES['image_upload'];
    $NewImgName        = setNameImg($caption);
    $dogsImg           = $f->uploadFile($file,$urlFile,$arExt,$maxSize,$NewImgName);
    
    if($dogsImg=="100"){
        $mess = "Invalid type of file";
        $td->assign('mess_img2',$mess);
        $td->assign('mess_img1',"Error:");
       

        $do_save = -1;
    }
    if($dogsImg=="101"){
        $mess = "File size must be under 3MB";
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
        $sql1   ="INSERT INTO dogs(img,dog_name,subcontent,fullcontent)
                    VALUES 	('$dogsImg','$dogsName','$dogsSubcontent','$dogsFullcontent');";
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