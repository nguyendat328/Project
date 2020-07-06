<?php
$td = new XTemplate("views/Dogfood/add_food_category.html");
$td->assign('baseUrl',$baseUrl);

if(isset($_POST['txtName'])){
    $categoryName = trim($_POST['txtName']);
    $sql1   ="INSERT INTO food_catalogies(catalogies) VALUES('$categoryName');";
    $db->execSQL($sql1);
    $f->direction("?m=table&a=Dogfood"); 
}; 

$td->parse('ADD');
    $content = $td->text('ADD');