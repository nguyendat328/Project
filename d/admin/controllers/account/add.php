<?php
$td = new XTemplate("views/account/add.html");
$td->assign('baseUrl',$baseUrl);
$do_save=1;

if($permission!='admin'){
    echo"<script>alert('This account has not permission for this action')</script>";
    $f->direction("?m=table&a=account");
    
}else{
    if(isset($_POST['txtUserName']) 
    ){
        $username       = trim($_POST['txtUserName']);
        $per            = $_POST['txtPermission'];
        $pass           = sha1($_POST['txtPass']);
        $repass         = sha1($_POST['txtRePass']);
        $email          = $_POST['txtEmail'];
        $file           = $_FILES['image_upload'];
        $NewImgName     = setNameImg($username);
        $Img            = $f->uploadFile($file,$urlFile,$arExt,$maxSize,$NewImgName);
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
            
            //chen thong tin vao bang
            $sql1   ="INSERT INTO account(img,username,password,email,permission)
                        VALUES 	('$Img','$username','$pass','$email','$per');";
           
            $db->execSQL($sql1);
    
    
    
            
            
            
            
            
                $f->direction("?m=table&a=account");
            
        }
    
    
    
    
    } ; 

}



$td->parse('ADD');
    $content = $td->text('ADD');