<?php
    header('Content-Type: text/html; charset=utf-8');
	include('../libs/bootstrap.php');
    $axp = new XTemplate('views/index.html');
    $axp->assign('site_title',$admin_title_site);
    $axp->assign('baseUrl',$baseUrl);
    session_start();
if(isset($_SESSION['user'])){
    $user       =$_SESSION['user'];
    $sql_getUser=" SELECT * FROM account 
                    WHERE username='$user';";
    $arruser    = $db->fetchOne($sql_getUser);
    $userId     = $arruser['id'];
    $Name       = $arruser['username'];
    $Mail       = $arruser['email'];
    $permission = $arruser['permission'];
    $userImg    = $arruser['img'];
    $axp->assign('username',$Name);
    $axp->assign('email',$Mail);
    $axp->assign('userImg',$userImg);
    $axp->assign('id',$userId);
    if(isset($_POST["txtLogout"])){
        session_destroy();
        header("Location: $baseUrl/admin/login.php");        
    }
    if(!empty($_GET["m"])){
        $m = $_GET['m'];
	    $a = $_GET['a'];
    }
    if(!empty($a)&&!empty($m)){
        if(file_exists("controllers/{$m}/{$a}.php")){
            include("controllers/{$m}/{$a}.php");
            $axp->assign('content',$content);
        } 
    }
// CONTROL  LEFT SIDE-------------------
    $ar= array("Type dog","Country","Dog food","Dog news","Gallery","Dog FAQ","Contact"); 
 foreach($ar as $arr){
    $axp->assign('dasboard',$arr);
    $axp->assign('dasb_link',str_replace(' ','',$arr));
    $axp->parse('ADMIN_PAGE.TABLE_NAME');
 };
// CONTROL TYPEDOG_TABLE
 $axp->parse('ADMIN_PAGE');
 $axp->out('ADMIN_PAGE');

}else{
    header("Location: $baseUrl/admin/login.php");
}