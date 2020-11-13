<?php
session_start();
//for checking is the user is already loggedin to prevent this page from always displaying
if(isset($_SESSION["is_logged_in"]) && $_SESSION['is_logged_in'] =="auth")
{header('Location: logout.php'); die();}

require_once('includes/config.php');
require_once("libs/DatabaseClass.php");
$login_class = new Civil();

if (isset($_POST['login']))
{
  if ((isset($_POST['username']) || !empty($_POST['username'])) && (isset($_POST['password']) || !empty($_POST['password']))){
  extract ($_REQUEST);
  $username = $_POST['username'];
  $password = md5($_POST['password']);

  $query="select * from user_base where username='{$username}'";
  $return_username="";
  $return_password="";
  //querrying the database to check if user exist in database
  $result = $login_class->validate_admin($query);
  //$result = connect_db($query);
  $return_result=$result['result'];
  $return_affected=$result['affected'];
  //using the return result
  if($return_result !=="false")
    {
      if($return_affected==1)
      {
        while($disp=mysqli_fetch_array($return_result))
        {
          $return_username=$disp['username'];
          $return_password=$disp['password'];
        }
      
        if($return_username==$username)
        {
          if ($return_password==$password)
          {
            $_SESSION['is_logged_in'] ="auth";
            echo '<script type="text/javascript">
                alert("You have login succesfully '.$username.'.");
                      window.location = "dashboard.php";
                    </script>';
          }
          else
          {
            $regerror =  "The password you’ve entered is incorrect.</br>";
          }
        }

        else
        {
          $regerror =  "Invalid username or password.(Username and password are case sensitive).</br>";
        }
      }
      else
        $regerror =  "There is a problem with your account. Please contact customer care.</br>";
    }

    else
    {
      $regerror =  "Account does not exist. Please create a new account if you dont have one.</br>";
    }
  }
  else
    $regerror =  "All field are required, Please enter all record.";
}
?>

<html lang="en">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Civil Engineering Admin Panel</title>
  <!-- BOOTSTRAP STYLES-->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
     <!-- FONTAWESOME STYLES-->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
        <!-- CUSTOM STYLES-->
    <link href="assets/css/custom.css" rel="stylesheet" />
     <!-- GOOGLE FONTS-->
   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
</head>
<body>
  
    <div id="wrapper">
         <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="adjust-nav">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php">
                        <img src="assets/img/valpo_logo.png" />

                    </a>
                    
                </div>
            </div>
        </div>
        <div id="page-inner">
            <div class="row">
              <div class="col-md-12">
                   
                <form class="form-signin" method="POST">
                  <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"></div>
                   <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                    <br>
                    <center><h2>LOGIN PAGE </h2></center><br>
                      <?php require_once('components/message_section.php');?>
                      <div class="input-group">
                        <span class="input-group-addon">Username</span>
                        <input type="text" name="username" class="form-control" placeholder="Enter your username" required />
                      </div>

                      <br>
                      <div class="input-group">
                        <span class="input-group-addon">Password</span>
                        <input type="password" name="password" class="form-control" placeholder="Enter your password" required />
                      </div>
                      <br>
                      <div>
                        <button class="btn btn-lg btn-primary btn-block" name="login" type="submit">Log In</button>
                      </div>
                 </div>
                 <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"></div>
                  
              </form>  
            </div>
          </div>              
          <!-- /. ROW  -->
          <hr/>
        <!-- /. ROW  -->           
      </div>
          
 <!-- /. PAGE WRAPPER  -->
        </div>
    <div class="footer">
            <div class="row">
                <div class="col-lg-12" >
                    &copy;  2017 | Design by: CS 358 Team Civil Engineering Group (Spring)
                </div>
            </div>
        </div>
          

     <!-- /. WRAPPER  -->
    <!-- SCRIPTS -AT THE BOTOM TO REDUCE THE LOAD TIME-->
    <!-- JQUERY SCRIPTS -->
    <script src="assets/js/jquery-1.10.2.js"></script>
      <!-- BOOTSTRAP SCRIPTS -->
    <script src="assets/js/bootstrap.min.js"></script>
      <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>
    
   
</body>
</html>