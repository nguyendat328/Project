<?php
    $home = new XTemplate("views/tables/home.html");

    $sql = "SELECT * from food_catalogies";
    $sql2 = "SELECT food_catalogies.id, food.img, food.title FROM food,food_catalogies WHERE food_catalogies.id = food.id_cat";
    $rs2 = $db->fetchAll($sql2);
    // echo json_encode($rs2);die;
    $rs = $db->fetchAll($sql);
    $nbr = 1;
    $i =0;
    foreach($rs as $val) {
        $val['nbr'] = $nbr++;
        $val['active'] = $i == 0 ? 'current-2' : '';
        $home->assign('THUCAN',$val);
        $home->parse('HOME.THUCAN');
        $i++;
    }
    $i =0;
    
    // $a = 1;
    $tests = array("ldsancl",'ads','fadsfd','kagfka');
   

    foreach($rs2 as $vals) {
        $vals['active'] = $i == 0 ? 'active show' : '';
        // if ($vals->id_cat) {
            foreach($tests as $test) {
                $home->assign('test',$test);
                $home->parse('HOME.DETAIL.LS');
            }
        // }
        

        $home->assign('DETAIL',$vals);
        $home->parse('HOME.DETAIL');
        $i++;
    }

   


    $home->parse("HOME");
	$content = $home->text("HOME");

?>