<?php
$td = new XTemplate("views/gallery/editalbum.html");
$td->assign('baseUrl',$baseUrl);

// lấy thông tin và đẩy ra các trường có sẵn
if(isset($_GET['id'])){
    $id_d=$_GET['id'];
    //lấy thông tin
    $sql_getdogs    =" SELECT *
                    FROM album  
                    WHERE id=$id_d;";
    $arrd = $db->fetchOne($sql_getdogs);
    //đẩy thông tin vào các trường
    if($arrd){
        $album       =$arrd['album'];     
        $td->assign('album_title',$album);
    }  
    
}
// quá trình update
    if(isset($_POST['txtAlbum'])){
        $album       = trim($_POST['txtAlbum']);

                
                    $sql        ="UPDATE album
                                    SET album ='$album'
                                    WHERE id=$id_d;";
                    $db->execSQL($sql);

        $f->direction("?m=table&a=album"); 

    };

$td->parse('EDIT');
    $content = $td->text('EDIT');