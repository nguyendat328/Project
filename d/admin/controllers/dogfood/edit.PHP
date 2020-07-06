<?php
$td = new XTemplate("views/Dogfood/edit.html");
$td->assign('baseUrl',$baseUrl);
$do_save=1;
//lấy danh sách loại thức ăn
$sql_getcategory="SELECT id,catalogies FROM food_catalogies WHERE 1;";
$arr2 = $db->fetchAll($sql_getcategory); 
    foreach($arr2 as $c){
        $td->insert_loop("EDIT.S_CATEGORY",array("S_CATEGORY"=>$c)); 
    }


if(isset($_GET['id'])){
    $id_d=$_GET['id'];
    //lấy thông tin 
    $sql_getfood="  SELECT img,title,title_sign, subcontent,fullcontent, price, origin, id_cat
                    FROM food  
                    WHERE id=$id_d;";

    $arrd = $db->fetchOne($sql_getfood);
    
    //đẩy thông tin vào các trường
    if($arrd){
        $img            = $arrd['img'];
        $title          = $arrd['title'];
        $title2         = $arrd['title_sign'];
        $sub            = $arrd['subcontent'];
        $full           = $arrd['fullcontent'];
        $price          = $arrd['price'];
        $origin         = $arrd['origin'];
        $td->assign('title',$title);
        $td->assign('title_sign',$title2);
        $td->assign('subcontent',$sub);
        $td->assign('fullcontent',$full);
        $td->assign('food_price',$price);
        $td->assign('food_origin',$origin);
    }
}

    if(isset($_POST['txtTitle'])){
         $title          = trim($_POST['txtTitle']) ;
         $category           = $_POST['txtcategory'] ;
         $title2             = $_POST['txtTitle2'] ;
         $food_Subcontent    = $_POST['s_content'] ;
         $food_Fullcontent   = $_POST['f_content'] ;
         $food_price         = $_POST['txtprice'] ;
         $food_origin        = $_POST['txtorigin'] ;
        $file              = $_FILES['image_upload'];
        $NewImgName        = setNameImg($title);
        $Img        = $f->uploadFile($file,$urlFile,$arExt,$maxSize,$NewImgName);
        if($file['error']==4){
            $sql_upfood=" UPDATE food
            SET title           = '$title',
                title_sign      = '$title2',
                subcontent      = '$food_Subcontent',
                fullcontent     = '$food_Fullcontent',
                price           = '$food_price',
                origin          = '$food_origin',
                id_cat          = '$category'
            WHERE id=$id_d;";
            $db->execSQL($sql_upfood);
        }else{
            if($Img=="100"){
                $mess = "Invalid type of file";
                $td->assign('mess_img2',$mess);
                $td->assign('mess_img1',"Error:");   
                $do_save = -1;
            }
            if($Img=="101"){
                $mess = "File size must be under 2MB";
                $td->assign('mess_img2',$mess);
                $td->assign('mess_img1',"Error:");
                $do_save = -1;
            }
            if(empty($Img)){
                $mess = "File upload Faile!";
                $td->assign('mess_img2',$mess);
                $td->assign('mess_img1',"Error:");
                $do_save = -1;
            }
            if($do_save==1){
                $sql_getImg = "SELECT img FROM food WHERE id = $id_d;";
                $arr_img        =$db->fetchOne($sql_getImg);
                $img_name   =$arr_img['img'];
                $filename   ="./img/".$img_name;
                unlink($filename);
                
                $sql_upfood="  UPDATE food
                SET 
                    img              ='$Img', 
                    title            = '$title',
                    title_sign       = '$title2',
                    subcontent      = '$food_Subcontent',
                    fullcontent     = '$food_Fullcontent',
                    price           = '$food_price',
                    origin          = '$food_origin',
                    id_cat     = '$category'
                WHERE id=$id_d;";
                $db->execSQL($sql_upfood);
 
            }
        }

        $f->direction("?m=table&a=Dogfood"); 
    };



$td->parse('EDIT');
    $content = $td->text('EDIT');