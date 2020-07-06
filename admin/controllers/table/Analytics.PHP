<?php
$td = new XTemplate("views/table/Analytics.html");
$td->assign('baseUrl',$baseUrl);
$sql1="SELECT COUNT(id) AS t FROM dogs;";
$sql2="SELECT COUNT(id) AS t FROM country;";
$sql3="SELECT COUNT(id) AS t FROM food;";
$sql4="SELECT COUNT(id) AS t FROM news;";
$sql5="SELECT COUNT(id) AS t FROM gallery;";
$sql6="SELECT COUNT(id) AS t FROM faq;";
$sql7="SELECT COUNT(id) AS t FROM cus_contact;";
$ar1 = $db->fetchOne($sql1);
$ar2 = $db->fetchOne($sql2);
$ar3 = $db->fetchOne($sql3);
$ar4 = $db->fetchOne($sql4);
$ar5 = $db->fetchOne($sql5);
$ar6 = $db->fetchOne($sql6);
$ar7 = $db->fetchOne($sql7);



$var1 = $ar1['t'];
$var2 = $ar2['t'];
$var3 = $ar3['t'];
$var4 = $ar4['t'];
$var5 = $ar5['t'];
$var6 = $ar6['t'];
$var7 = $ar7['t'];


$td->assign('dog',$var1);
$td->assign('country',$var2);
$td->assign('food',$var3);
$td->assign('news',$var4);
$td->assign('gallery',$var5);
$td->assign('faq',$var6);
$td->assign('contact',$var7);


$sqlr="SELECT COUNT(id) AS t FROM cus_contact WHERE response =0;";
$arr = $db->fetchOne($sqlr);
$varr = $arr['t'];
$td->assign('request',$varr);




$td->parse('TABLE');
    $content = $td->text('TABLE');


