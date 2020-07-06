<?php
$td = new XTemplate("views/account/edit.html");
$td->assign('baseUrl',$baseUrl);
if($permission!='admin'){
    echo"<script>alert('This account has not permission for this action')</script>";
    $f->direction("?m=table&a=account");
    
}else{
    if(isset($_GET['id'])){
        $id_d=$_GET['id'];
        //lấy thông tin
        $sql_get    ="  SELECT *
                        FROM account 
                        WHERE id=$id_d;";    
        $arrd = $db->fetchOne($sql_get);
        //đẩy thông tin vào các trường

        if($arrd){
            $username       =$arrd['username'];
            $email       =$arrd['email'];
            $per       =$arrd['permission'];
            if($per=='admin'){
                $td->assign('disabled',"disabled");
            }
            $td->assign('UserName',$username);
            $td->assign('Email',$email);
            
        }
            
    }
    // quá trình update
    $do_save=1;
    
        if(isset($_POST['txtUserName'])){
        $username       = trim($_POST['txtUserName']);
            if($per=='admin'){
                $per='admin';
            }else{
                $per            = $_POST['txtPermission'];  
            }
        $pass           = sha1($_POST['txtPass']);
        $repass         = sha1($_POST['txtRePass']);
        $email          = $_POST['txtEmail'];
        $file           = $_FILES['image_upload'];
        $NewImgName     = setNameImg($username);
        $Img            = $f->uploadFile($file,$urlFile,$arExt,$maxSize,$NewImgName);
        
         //update neu khon up moi avata   
        if($file['error']==4){
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $mess = "Invalid email format";
                    $td->assign('mess_img2',$mess);
                    $td->assign('mess_img1',"Error:");
                    $do_save = -1;
                  }elseif($pass!=$repass){
                    $mess = "Re-Password must be equal Password ";
                    $td->assign('mess_img2',$mess);
                    $td->assign('mess_img1',"Error:");
                    $do_save = -1;
                }else{
                    $sql_up="  UPDATE account
                    SET username    ='$username',
                        password    ='$pass',
                        email       ='$email',
                        permission  ='$per'
                    WHERE id=$id_d;";
                    $db->execSQL($sql_up);
                   
                    $do_save = -1;
                }

               
        }else{
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $mess = "Invalid email format";
                $td->assign('mess_img2',$mess);
                $td->assign('mess_img1',"Error:");
                $do_save = -1;
            }
            if($pass!=$repass){
                $mess = "Re-Password must be equal Password ";
                $td->assign('mess_img2',$mess);
                $td->assign('mess_img1',"Error:");
                $do_save = -1;
            }
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
                $sql_getImg= "SELECT img FROM account WHERE id = $id_d;";
                $img=$db->fetchOne($sql_getImg);
                $img_name=$img['img'];
                $filename="./img/".$img_name;
                unlink($filename);
                $sql_up="  UPDATE account
                            SET img         ='$Img',
                                username    ='$username',
                                password    ='$pass',
                                email       ='$email',
                                permission  ='$per'
                            WHERE id=$id_d;";
                $db->execSQL($sql_up); 
                }
            }
        
            $f->direction("?m=table&a=account"); 
  
    
        };

}


$td->parse('EDIT');
    $content = $td->text('EDIT');