<?php
$td = new XTemplate("views/gallery/edit.html");
$td->assign('baseUrl',$baseUrl);

// lấy thông tin và đẩy ra các trường có sẵn
if(isset($_GET['id'])){
    $id_d=$_GET['id'];
    //lấy thông tin
    $sql_getdogs    =" SELECT *
                    FROM gallery  
                    WHERE id=$id_d;";
    $arrd = $db->fetchOne($sql_getdogs);
    //đẩy thông tin vào các trường
    if($arrd){
        $caption       =$arrd['caption'];     
        $td->assign('caption',$caption);
    }
   
    $sql_get="SELECT id,album FROM album WHERE 1;";
    $arr2 = $db->fetchAll($sql_get); 
        foreach($arr2 as $c){
            $td->insert_loop("EDIT.ALBUM",array("ALBUM"=>$c));  
        }
}
// quá trình update
$do_save=1;

    if(isset($_POST['txtcaption'])){
        $caption       = trim($_POST['txtcaption']);
        $album          = $_POST['selectAlbum'];
 
        $file           = $_FILES['img_upload'];
       
        $NewImgName     = setNameImg($caption);
        $Img            = $f->uploadFile($file,$urlFile,$arExt,$maxSize,$NewImgName);
        if($file['error']==4){
            if($album=="noAlbum"){
                
                    $sql        ="UPDATE gallery
                                    SET caption= '$caption'
                                    WHERE id=$id_d;";
                    $db->execSQL($sql);
                     
               }else{
                  //chen thong tin vao bang gallery
                
                    $sql        ="UPDATE gallery
                                    SET caption= '$caption'
                                    WHERE id=$id_d;";
                    
                    $sql2       = "UPDATE gallery_album
                                    SET id_album ='$album'
                                    WHERE id_gallery=$id_d;";
                    $db->execSQL($sql2);
                     
                }
            $do_save = -1;
        }else{
            if($Img=="100"){
                $mess = "Invalid type of file";
                $td->assign('mess_img2',$mess);
                $td->assign('mess_img1',"Error:");   
                $do_save = -1;
            }
            if($Img=="101"){
                $mess = "File size must be under 3MB";
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
                ///delete ảnh
                $sql_getImg= "SELECT img FROM gallery WHERE id = $id_d;";
                $imgd=$db->fetchOne($sql_getImg);
                $img_name=$imgd['img'];
                $filename="./img/".$img_name;
                unlink($filename);
                if($album=="noAlbum"){
                
                    $sql        ="UPDATE gallery
                                    SET img='$Img', caption= '$caption'
                                    WHERE id=$id_d;";
                    $db->execSQL($sql);
                     
               }else{
                  
                
                    $sql        ="UPDATE gallery
                                    SET img='$Img', caption= '$caption'
                                    WHERE id=$id_d;";
                    
                    $sql2       = "UPDATE gallery_album
                                    SET id_album ='$album'
                                    WHERE id_gallery=$id_d;";
                    $db->execSQL($sql2);
                     
                }
            }
                
        }
    
        $f->direction("?m=table&a=gallery"); 

    };


$td->parse('EDIT');
    $content = $td->text('EDIT');