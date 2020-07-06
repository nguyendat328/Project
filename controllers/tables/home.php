<?php
    $home = new XTemplate("views/tables/home.html");
    $home->assign('baseUrl',$baseUrl);
    
   
    
//BEGIN------------------------in ra DOGS hight light------------------------------------------------------------//
    $sqlh       ="SELECT COUNT(id) AS t FROM dogs WHERE highlight=1;";
    $arr1       = $db->fetchOne($sqlh);
    $TotalHL    =$arr1['t'];
    if($TotalHL<6){
       $sqld    ="SELECT * FROM dogs WHERE 1 ORDER BY RAND() LIMIT 6; " ;
    }else{
        $sqld   ="SELECT * FROM dogs WHERE highlight=1 ORDER BY RAND() LIMIT 6; ";
    }
    $arr2       =$db->fetchAll( $sqld);
    $i          =0;
    foreach ($arr2 as $values) {
            if($i==0){
                    $home->assign('active','active');
                    $home->assign('current','current');

                }else{
                    $home->assign('active',''); 
                    $home->assign('current','');

    
                }
        $home->insert_loop("HOME.DOG",array("DOG"=>$values));
        $home->insert_loop("HOME.DOG_VIEW",array("DOG_VIEW"=>$values));
        $i++;

    }

//END------------------------------------------------------------------------------------//

//BEGIN-------  in ra hight news-----------------------------------------------------------------------------//

$sql5 = "SELECT * FROM news WHERE highlight=1 ORDER BY RAND() LIMIT 3;";
$rs5 = $db->fetchALL($sql5);
    foreach($rs5  as $news) {
        $news['active'] = $i == 0 ? 'current-2' : '';
        $home->assign('LIST',$news);
        $home->parse('HOME.NEWS');

    }
//END------------------------------------------------------------------------------------//

//BEGIN-------  in ra slide dogs-----------------------------------------------------------------------------//

    $sql3 = "SELECT * FROM dogs ORDER BY RAND() LIMIT 5";
    $rss3 = $db->fetchAll($sql3);
    foreach ($rss3 as $values) {
        $home->insert_loop("HOME.SLIDE",array("SLIDE"=>$values));

    }
//END------------------------------------------------------------------------------------//

//BEGIN-------  in ra slide food-----------------------------------------------------------------------------//

$sql4 = "SELECT * FROM food ORDER BY RAND() LIMIT 5;";
$rss4 = $db->fetchAll($sql4);
foreach ($rss4 as $vas) {
    $home->insert_loop("HOME.FOOD",array("FOOD"=>$vas));

}
//END------------------------------------------------------------------------------------//
    // $i =0;
    
    // foreach($rss as $val) {
    //     $val['active'] = $i == 0 ? 'current-2' : '';
    //     $home->assign('THUCAN',$val);
    //     $home->parse('HOME.THUCAN');
    //     $i++;
    // }
    // $i =0;
   
    // foreach($rss as $key => $vals) {
    //     $vals['active'] = $i == 0 ? 'active show' : '';
    //     $at = $vals['id'];
        
    //     foreach($rss2 as $test) {
    //         if ($test['id_cat'] == $at) {
    //             $home->assign('test',$test);
    //             $home->parse('HOME.DETAIL.LS');
    //         } 
    //     }

    //     $home->assign('DETAIL',$vals);
    //     $home->parse('HOME.DETAIL');
    //     $i++;
    // }

    


    $home->parse("HOME");
	$content = $home->text("HOME");

?>