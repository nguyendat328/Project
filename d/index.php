<?php
    
	include('libs/bootstrap.php');
    $hxtp = new XTemplate('views/index.html');
    $hxtp->assign('homepage',$homepage);
    $hxtp->assign('baseUrl',$baseUrl);
    
    $a = 'Home';
    if($_GET){
        $m = $_GET['m'];
        $a = $_GET['a'];
    
        if(isset($m)&&isset($a)){
            if ( file_exists("controllers/{$m}/{$a}.php")) {
                include("controllers/{$m}/{$a}.php");
                $hxtp->assign("content",$content);
            } else {
                //show message 404
            }
        }
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
            "active" => $a == 'news' ? 'active1' : '',
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
    

    $hxtp->parse('LAYOUT');
    $hxtp->out('LAYOUT');