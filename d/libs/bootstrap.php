<?php
	$homepage = "Patrona";
	$admin_title_site = 'Patronal Admin Website';
	include("XTemplate.class.php");
	include("dbSmart.class.php");
	include("Validation.class.php");
	include("Recycle.class.php");
	$dsn="mysql:host=localhost;dbname=c1904l_project1";
	$userName="c1904l";
	$pass="123456";
	$db= new dbSmart($dsn,$userName,$pass);
	$valid=new Validation;
	$f =  new Recycle;
	//bien kiem tra quyen han
	//full quyền hạn content= thêm, xoá, sửa trong content tới database
	//full quyền hạn account= thêm, xoá, sửa account trừ việc xoá admin
	
	//Quy định permission :
	
	// admin: chỉ tạo được quyền này từ database có full quyền hạn content và account
	// managerpro: tạo dc quyền từ web, có full quyền hạn content
	// manager:tạo dc quyền từ web có quyền thêm và sửa content
	$permission ='';
	// $dog_tye_title_site = 'Project Aptech.C1904L: Admin Panel';
	// $dog_food_title_site = 'Project Aptech.C1904L: Admin Panel';
	// $dog_care_title_site = 'Project Aptech.C1904L: Admin Panel';
	// $dog_gal_title_site = 'Project Aptech.C1904L: Admin Panel';
	// $dog_new_title_site = 'Project Aptech.C1904L: Admin Panel';

	$baseUrl = 'http://'.$_SERVER['HTTP_HOST'].'/aptech-project/project/';
	// biến dùng lưu file
	$arExt = array('jpg','png','jpeg','gif');
	$maxSize = 2000000;
	$urlFile = './img/' ;

//function get last id
	function getlastID($db,$sql){
		$db->execSQL($sql);
		$stmt = $db->fetchOne("SELECT LAST_INSERT_ID() as id");
		return $stmt['id'];
	}
// function bỏ dấu tiếng việt
function vn_to_str($str){ 
	$unicode = array(	 
	'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',	 
	'd'=>'đ',	 
	'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',	 
	'i'=>'í|ì|ỉ|ĩ|ị',	 
	'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',	 
	'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',	 
	'y'=>'ý|ỳ|ỷ|ỹ|ỵ',	 
	'A'=>'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',	 
	'D'=>'Đ',	 
	'E'=>'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',	 
	'I'=>'Í|Ì|Ỉ|Ĩ|Ị',	 
	'O'=>'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',	 
	'U'=>'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',	 
	'Y'=>'Ý|Ỳ|Ỷ|Ỹ|Ỵ',	 
	);
	foreach($unicode as $nonUnicode=>$uni){	 
	$str = preg_replace("/($uni)/i", $nonUnicode, $str);	 
	}
	return $str;	 
	}
	function setNameImg($str){
		$re='/[\/ \? \: \* \? \" \< \> \| \, \s]/m';
		$r='/[^a-z A-Z 0-9]/m';
		$str=vn_to_str($str);
		$str= trim($str);
		$str= preg_replace($r,"-", $str);
		$str=str_replace(" ","-",$str);
		return $str;
	}
	
// phần test
