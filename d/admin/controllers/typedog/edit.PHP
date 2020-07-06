<?php
$td = new XTemplate("views/typedog/edit.html");
$td->assign('baseUrl',$baseUrl);

// lấy thông tin và đẩy ra các trường có sẵn
if(isset($_GET['id'])){
    $id_d=$_GET['id'];
    //lấy thông tin chó, country,picture
    //chó
    $sql_getdogs    ="  SELECT a.dog_name,a.subcontent,a.fullcontent
                    FROM dogs AS a 
                    WHERE id=$id_d;";

    $arrd = $db->fetchOne($sql_getdogs);
    //đẩy thông tin vào các trường
    if($arrd){
        $name       =$arrd['dog_name'];
        $sub        =$arrd['subcontent'];
        $full       =$arrd['fullcontent'];
        $td->assign('dog_name',$name);
        $td->assign('subcontent',$sub);
        $td->assign('fullcontent',$full);
    }
    //country
    $sql_getcontryid="  SELECT a.id_country
                        FROM dogs_country AS a 
                        WHERE id_dogs=$id_d;";
    $arrc = $db->fetchOne($sql_getcontryid);
        $id_c=$arrc['id_country'];
    //đẩy thông tin vào các trường
    $sql_getcountry="SELECT country.id, country.countryname FROM country WHERE 1;";
    $arr2 = $db->fetchAll($sql_getcountry); 
    foreach($arr2 as $c){
        // if($c['id']==$id_c){
        //     $td->assign('select','selected'); 
        //  }
        $td->insert_loop("EDIT.S_COUNTRY",array("S_COUNTRY"=>$c));
        
    }
}
// quá trình update
$do_save=1;

    if(isset($_POST['txtName'])){
        $dogsName          = trim($_POST['txtName']);
        $dogsCountryid     = $_POST['txtCountry'];
        $dogsSubcontent    = $_POST['s_content'];
        $dogsFullcontent   = $_POST['f_content'];
        $file              = $_FILES['image_upload'];
        $NewImgName        = setNameImg($dogsName  );
        $dogsImg           = $f->uploadFile($file,$urlFile,$arExt,$maxSize,$NewImgName);
        if($file['error']==4){
            $sql_updogs="  UPDATE dogs
            SET dog_name='$dogsName',
                subcontent='$dogsSubcontent',
                fullcontent='$dogsFullcontent'
            WHERE id=$id_d;";
            $db->execSQL($sql_updogs);
            //update DOGS_country
            $sql_upIDcountry="  UPDATE dogs_country 
                                SET id_country='$dogsCountryid'
                                WHERE id_dogs=$id_d;"; 
            $db->execSQL($sql_upIDcountry);    
            $do_save = -1;
        }else{
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
                //update dog
                 //delete ảnh
                $sql_getImg= "SELECT img FROM dogs WHERE id = $id_d;";
                $img=$db->fetchOne($sql_getImg);
                $img_name=$img['img'];
                $filename="./img/".$img_name;
                unlink($filename);
                $sql_updogs="  UPDATE dogs
                SET 
                    img ='$dogsImg', 
                    dog_name='$dogsName',
                    subcontent='$dogsSubcontent',
                    fullcontent='$dogsFullcontent'
                WHERE id=$id_d;";
                $db->execSQL($sql_updogs);
                //update DOGS_country
                $sql_upIDcountry="  UPDATE dogs_country 
                                    SET id_country='$dogsCountryid'
                                    WHERE id_dogs=$id_d;"; 
                $db->execSQL($sql_upIDcountry);   
            }
        }
    
        $f->direction("?m=table&a=Typedog"); 





      


    };
   
   







/*
$do_save=1;
$arExt = array('jpg','png','jpeg','gif');
$maxSize = 3000000;
$urlFile = 'F:\\xampp\\htdocs\\aptech-project\\puppy\\admin\\img\\' ;
$urlFiletmp='F:\\xampp\\htdocs\\aptech-project\\puppy\\admin\\img\\tmp';


if(
isset($_POST['txtNae'])&&
isset($_POST['txtCountry'])&&
isset($_POST['s_content'])&&
isset($_POST['f_content']) 
){
    $dogsName          = trim($_POST['txtName']);
    $dogsCountryid     = $_POST['txtCountry'];
    $dogsSubcontent    = $_POST['s_content'];
    $dogsFullcontent   = $_POST['f_content'];
    $imgDiscription    = $_POST['dis_content'];
    $file              = $_FILES['image_upload'];
    $NewImgName        = str_replace(' ','-',$dogsName);
    $dogsImg= $f->uploadFile($file,$urlFile,$arExt,$maxSize,$NewImgName);
    
    
    if($dogsImg=="100"){
        $mess = "Invalid type of file";
        $td->assign('mess_img',$mess);
        $td->assign('display','display:block');

        $do_save = -1;
    }
    if($dogsImg=="101"){
        $mess = "File size must be under 3MB";
        $td->assign('mess_img',$mess);
        $do_save = -1;
    }
    if(empty($dogsImg)){
        $mess = "File upload Faile!";
        $td->assign('mess_img',$mess);
        $do_save = -1;
    }
    if($do_save==1){
        //chen thong tin vao bang chó
        $sql1   ="INSERT INTO dogs(dog_name,subcontent,fullcontent)
                    VALUES 	('$dogsName','$dogsSubcontent','$dogsFullcontent');";
        $dog_id = getlastID($db,$sql1);//lấy ra id  chó mới chèn vào
        //chèn thông tin tham chiếu  bảng chó_qg
        $sql1_1 ="INSERT INTO dogs_country(id_dogs,id_country) 
                    VALUES	('$dog_id','$dogsCountryid');";
        $db->execSQL($sql1_1);
        //chen thong tin vao bang picture
        $sql2   ="INSERT INTO picture_d(img_name,title)
                        VALUES	('$dogsImg','$dogsName');";
        $pic_id = getlastID($db,$sql2);
        //chèn thông tin tham chiếu  bảng chó_picture
        $sql2_1 ="INSERT INTO dogs_picture(id_dogs,id_picture) 
                        VALUES	('$dog_id','$pic_id');";
        $db->execSQL($sql2_1);


        
        
        
        
        
            $f->direction("?m=table&a=Typedog");
        
    }




} ; 
*/


$td->parse('EDIT');
    $content = $td->text('EDIT');