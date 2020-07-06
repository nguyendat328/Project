<?php
$td = new XTemplate("views/gallery/add.html");
$td->assign('baseUrl',$baseUrl);

$sql_get="SELECT id,album FROM album WHERE 1;";
$arr2 = $db->fetchAll($sql_get); 
    foreach($arr2 as $c){
        $td->insert_loop("ADD.ALBUM",array("ALBUM"=>$c));  
    }
$do_save=1;
//xu ly add img
 if(isset($_POST['add'])){    
    if($_POST['add']=='img'){
             
        $caption       = trim($_POST['txtcaption']);
        $album     = $_POST['selectAlbum'];
 
        $file              = $_FILES['img_upload'];
       
        $NewImgName    = set_Str_NoSign($caption);
        $Img           = $f->uploadFileMuti($file,$urlFile,$arExt,$maxSize,$NewImgName);
             
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
               if($album=="noAlbum"){
                foreach($Img as $ak){
                    $sql        ="INSERT INTO gallery(img,caption)
                                    VALUES 	('$ak','$caption');";
                        $db->execSQL($sql);
                     } 
               }else{
                  //chen thong tin vao bang gallery
                foreach($Img as $ak){
                    $sql1       ="INSERT INTO gallery(img,caption)
                                    VALUES 	('$ak','$caption');";
                    $gal_id     = getlastID($db,$sql1);
                    $sql2       = "INSERT INTO gallery_album(id_gallery,id_album) 
                                    VALUES('$gal_id','$album');";
                    $db->execSQL($sql2);
                     } 
                }
                   $f->direction("?m=table&a=gallery");
             }
        }

        //sy ly up album
        if($_POST['add']=='album'){
            $title         = trim($_POST['txtAlbum']);    
            $file          = $_FILES['album_upload'];            
            $NewImgName    = set_Str_NoSign($title);
            $Img           = $f->uploadFileMuti($file,$urlFile,$arExt,$maxSize,$NewImgName);
    
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
               $sql_set="INSERT INTO album(album)
                            VALUES('$title');";
                $album_id= getlastID($db,$sql_set);            
                   
                foreach($Img as $ak){
                    $sql1       ="INSERT INTO gallery(img,caption)
                                    VALUES 	('$ak','$title');";
                    $gal_id     = getlastID($db,$sql1);
                    $sql2       = "INSERT INTO gallery_album(id_gallery,id_album) 
                                    VALUES('$gal_id','$album_id');";
                    $db->execSQL($sql2);
                     }                                     
                   $f->direction("?m=table&a=album");                 
             }                      
        }

} ; 

$td->parse('ADD');
    $content = $td->text('ADD');