
<!DOCTYPE html>  
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="">
  <!-- Bootstrap Core CSS -->
  <link href=" css/bootstrap.min.css" rel="stylesheet">
  <!-- Menu CSS -->
  <link href=" css/sidebar-nav.min.css" rel="stylesheet">
  <link href=" css/redactor.css" rel="stylesheet">
  <!-- Custom CSS -->
  <link href=" css/style.css" rel="stylesheet">
  <!-- color CSS -->
  <link href=" css/default.css" id="theme" rel="stylesheet">
  <!-- ============================================================== -->
  <!-- All Jquery -->
  <!-- ============================================================== -->
  <script src=" js/jquery.min.js"></script>
  <script src=" js/jquery-3.4.1.min.js"></script>
  <!-- Bootstrap Core JavaScript -->
  <script src=" js/bootstrap.min.js"></script>
  <!-- Menu Plugin JavaScript -->
  <script src=" js/sidebar-nav.min.js"></script>
  <!--slimscroll JavaScript -->
  <script src=" js/jquery.slimscroll.js"></script>
  <script src=" js/custom.js"></script>
  <script src=" js/redactor.min.js"></script>
  <!-- ======================================================================================== -->
  <!------------------------ All php----------------------- -->
  <!-- =================================================================================== -->
  <?php
  session_start();
  $mess="";
    include('../libs/bootstrap.php');
    if(!empty($_POST['txtUser'])){
        $user    = $_POST['txtUser'];
        $pass    =sha1($_POST['txtPass']);

        $sql="SELECT * FROM account WHERE username='$user' AND password='$pass';";
        $arr=$db->fetchOne($sql);
        if(!empty($arr)){
            $_SESSION['user']=$arr['username'];
            $GLOBALS['permission']=$arr['permission'];
            header("Location: $baseUrl/admin/index.php" );
        }else{$mess="Invalid UserName or Password!";

        }
        
    
}
?>

</head>
<body>
  <!-- Preloader -->
  <div class="preloader">
    <div class="cssload-speeding-wheel"></div>
  </div>
  <section id="wrapper" class="new-login-register">
    <div class="new-login-box">
      <div class="white-box">
        <h3 class="box-title m-b-0">SYSTEM MANAGE FOR PATRONA PUPPY WEBSITE</h3>
        <small>Enter your details below</small>
        <form class="form-horizontal new-lg-form" id="loginform" method="POST">

          <div class="form-group  m-t-20">
            <div class="col-xs-12">
              <label>USER NAME<span style="color:red">*</span></label>
              <input class="form-control" type="text" name="txtUser" required="" placeholder="Username">
            </div>
          </div>
          <div class="form-group">
            <div class="col-xs-12">
              <label>Password<span style="color:red">*</span></label>
              <input class="form-control" type="password" name="txtPass" required="" placeholder="Password">
            </div>
            <div class="col-xs-12">
              <?php  echo"<span style='color:red'>".$mess."</span>"; ?>
            </div>
          </div>
         
            <div class="form-group text-center m-t-20">
              <div class="col-xs-12">
                <button class="btn btn-info btn-lg btn-block btn-rounded text-uppercase waves-effect waves-light" type="submit">Log In</button>
              </div>
            </div>

          </form>
        </div>
      </div>            


    </section>
   

  </body>
  </html>


