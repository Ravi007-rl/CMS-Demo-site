<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>

<?php
global $ConnectingDB;
if(isset($_POST["Submit"])){
  $Email           = $_POST["Email"];
  $Name            = $_POST["Name"];
  $Password        = $_POST["Password"];
  $Passwordlen     =strlen($Password);
  $Password        =md5($Password);
  $ConfirmPassword = $_POST["ConfirmPassword"];
  $ConfirmPassword =md5($ConfirmPassword);
  date_default_timezone_set("Asia/Kolkata");
  $CurrentTime=time();
  $DateTime=strftime("%B-%d-%Y %H:%M:%S",$CurrentTime);
  $records = $ConnectingDB->prepare('SELECT username FROM users WHERE username = :Email');
  $records->bindParam(':Email', $Email);
  $records->execute();
  $results = $records->fetchAll();

  if(empty($Email)||empty($Password)||empty($Name)||empty($ConfirmPassword)){
    $_SESSION["ErrorMessage"]= "All fields must be filled out";
    Redirect_to("Register.php");
  }elseif ($Passwordlen<8) {
    $_SESSION["ErrorMessage"]= "Password should be greater than 7 characters";
    Redirect_to("Register.php");
  }elseif ($Password !== $ConfirmPassword) {
    $_SESSION["ErrorMessage"]= "Password and Confirm Password should match";
    Redirect_to("Register.php");
  }elseif (count($results) > 0) {
    $_SESSION["ErrorMessage"]= "Email id already taken. Try Another One! ";
    Redirect_to("Register.php");
  }else{
    // Query to insert new admin in DB When everything is fine
    
    $sql = "INSERT INTO users(datetime,username,password,name)";
    $sql .= "VALUES(:dateTime,:username,:password,:Name)";
    $stmt = $ConnectingDB->prepare($sql);
    $stmt->bindValue(':dateTime',$DateTime);
    $stmt->bindValue(':username',$Email);
    $stmt->bindValue(':password',$Password);
    $stmt->bindValue(':Name',$Name);
    $Execute=$stmt->execute();
    if($Execute){
      $_SESSION["SuccessMessage"]="Singup Successfully";
      Redirect_to("index.php");

    }else {
      $_SESSION["ErrorMessage"]= "Something went wrong. Try Again !";
      Redirect_to("Register.php");
    }
  }
} //Ending of Submit Button If-Condition
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
  <link rel="stylesheet" href="Css/Styles.css">
  <title>Sign Up Page</title>
</head>
<body>
  <!-- NAVBAR -->
    <header>
  <div style="height:10px; background:#27aae1;"></div>
  <nav class="navbar navbar-expand-lg navbar-dark bg-light">
    <div class="container">
      <a href="#" class="navbar-brand text-dark"> <B>CMS </B></a>
      <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarcollapseCMS">
        <span class="navbar-toggler-icon"></span>
      </button>
      </div>

      <ul class="navbar-nav ml-auto">
        <li class="nav-item"><a href="index.php" class="nav-link text-dark">
          <i class="fa fa-user-plus"></i> Login</a></li>
      </ul>
      </div>
    </header>
    <div style="height:10px; background:#27aae1;"></div>
    <!-- HEADER END -->

     <!-- Main Area -->
<section class="container py-2 mb-4" >
  <div class="row">
    <div class="col-md-8 mx-auto" style="min-height:400px;">
      <?php
       echo ErrorMessage();
       echo SuccessMessage();
       
       ?>
       <br>
      <form class="" action="Register.php" method="post">
        <div class="card bg-primary text-light align-self-center ">
          <div class="card-header bg-primary align-self-center">
            <h1>Register</h1>
          </div>
          <div class="card-body bg-light ">
          <div class="form-group">
              <label for="Name"> <span class="FieldInfo text-dark"> Name: </span></label>
               <input class="form-control" type="text" name="Name" id="Name" value="">
               
            </div>

            <div class="form-group" >
              <label for="username"> <span class="FieldInfo text-dark"> Email: </span></label>
               <input class="form-control" type="email" name="Email" id="email"  value="">
            </div>
            
            <div class="form-group">
              <label for="Password"> <span class="FieldInfo text-dark"> Password: </span></label>
               <input class="form-control" type="password" name="Password" id="Password" value="" maxlength="10">
            </div>
            <div class="form-group">
              <label for="ConfirmPassword"> <span class="FieldInfo text-dark"> Confirm Password:</span></label>
               <input class="form-control" type="password" name="ConfirmPassword" id="ConfirmPassword"  value="" maxlength="10">
            </div>
            <div class="row">
              
            <div class="col-lg-6 mb-2 align-self-center mx-auto">
              <button type="submit"  name="Submit" class="btn btn-primary btn-block">
                  Sign Up
                </button>
              </div>

              
              
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>

</section>



    <!-- End Main Area -->
    <!-- FOOTER -->
     <div class="copyright bg-light">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
					  <center><p class="lead text-dark"><B>Develop By Ravi & Shubh Bros. <span id="year"></span> &copy; ---All Right Reserved.</B></p></center>
				</div>
            </div>
        </div>
    </div>
	<div style="height:10px; background:#27aae1;"></div>
    <!-- FOOTER END-->

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
<script>
  $('#year').text(new Date().getFullYear());
</script>
</body>
</html>
