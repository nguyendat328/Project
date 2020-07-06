<?php
    
	include('libs/bootstrap.php');
    $hxtp = new XTemplate('views/index.html');
	$pagetitle = "Patrona - Homepage";

    $hxtp->assign('pagetitle',$pagetitle);
    $hxtp->assign('baseUrl',$baseUrl);
    
    $a = 'Home';
    if($_GET['a']){
        $m = $_GET['m'];
        $a = $_GET['a'];
    
        if(isset($m)&&isset($a)){
            if ( file_exists("controllers/{$m}/{$a}.php")) {
                include("controllers/{$m}/{$a}.php");
                $hxtp->assign("content",$content);
            }else{header("Location: $baseUrl/views/404.php"); };
        }
    } else {
        header("Location: $baseUrl?m=tables&a=Home");
        // include("controllers/tables/Home.php");
        // $hxtp->assign("content",$content);
    }

    $ar = [
        [
            "name" => 'Home',
            "active" => $a == 'Home' ? 'active1' : '',
        ],
        [
            "name" => 'Dogs',
            "active" => $a == 'Dogs' ? 'active1' : '',
        ],
        [
            "name" => 'Countrys',
            "active" => $a == 'Countrys' ? 'active1' : '',
        ],
        [
            "name" => 'Foods',
            "active" => $a == 'Foods' ? 'active1' : '',
        ],
        [
            "name" => 'Gallery',
            "active" => $a == 'Gallery' ? 'active1' : '',
        ],
        [
            "name" => 'News',
            "active" => $a == 'News' ? 'active1' : '',
        ],
        [
            "name" => 'FAQ',
            "active" => $a == 'FAQ' ? 'active1' : '',
        ],
    ];

    foreach($ar as $arr){
        $hxtp->assign('dasboard',$arr);
        $hxtp->assign('dasb_link',str_replace(' ','',$arr['name']));
        $hxtp->parse('LAYOUT.MENU');
    }
    $sqlc="SELECT * FROM contact WHERE 1;";
    $arrc=$db->fetchOne($sqlc);
    $hxtp->assign('adress',$arrc['location']);
    $hxtp->assign('email',$arrc['email']);
    $hxtp->assign('phone',$arrc['phone']);
    $hxtp->assign('fb',$arrc['link_fb']);
    $hxtp->assign('ins',$arrc['link_ins']);
    $hxtp->assign('youtube',$arrc['link_youtube']);



    $hxtp->parse('LAYOUT');
    $hxtp->out('LAYOUT');