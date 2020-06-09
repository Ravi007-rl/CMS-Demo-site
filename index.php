<?php require_once("Includes/DB.php"); ?>
<?php require_once("Includes/Functions.php"); ?>
<?php require_once("Includes/Sessions.php"); ?>
<?php
if(isset($_SESSION["UserId1"])){
  Redirect_to("Blog.php?page=1");
}

if (isset($_POST["Submit"])) {
  $UserName = $_POST["Username"];
  $Password = $_POST["Password"];
  $Password = md5($Password);
  $sql="SELECT * FROM users WHERE username=:username AND password=:password";
  $statment = $ConnectingDB->prepare($sql);
  $statment -> bindParam(':username', $UserName , PDO::PARAM_STR);
  $statment -> bindParam(':password', $Password , PDO::PARAM_STR);
  $statment->execute();
  $Result = $statment->rowcount();
  $all = $statment->fetchAll(PDO::FETCH_BOTH);
  


  
  if (empty($UserName)||empty($Password)) {
    $_SESSION["ErrorMessage"]= "All fields must be filled out";
    Redirect_to("UserLogin.php");
  }elseif($Result>0) {
    // code for checking username and password from Database
    $Found_Account=Login_Attempt($UserName,$Password);
    foreach($all as $all)
    {
      $_SESSION["UserId1"]=$all["id"];
      $_SESSION["UserName1"]=$all["username"];
      $_SESSION["UsernName"]=$all["name"];
      $_SESSION["attempt"]=$all["attempt"];
      if($_SESSION["attempt"]<=3)
      {

        
          $_SESSION["SuccessMessage"]= "Wellcome ".$_SESSION["UsernName"] . "!";
          Redirect_to("Blog.php?page=1");echo $all['id'] ;
        
      }
      else{
        /*$sql1="SELECT id,attempt FROM users WHERE username=:username";
        $statment1 = $ConnectingDB->prepare($sql);
        $statment1 -> bindParam(':username', $UserName , PDO::PARAM_STR);
        $statment1 ->execute();
        $all1 = $statment->fetch();
        print_r($all);
        die;
        foreach($all1 as $all1)
        {
          $_SESSION["attempt"]=$all["attempt"];
          $_SESSION["id"]=$all["id"];
          $attempt=$_SESSION["attempt"]+1;

          $sql = "UPDATE users SET attempt=? WHERE id=?";
          $ConnectingDB->prepare($sql)->execute($attempt);*/

          $_SESSION["ErrorMessage"]="Incorrect Username/Password";
          Redirect_to("index.php");
        //}  
      }   
    }
    }else {
      $_SESSION["ErrorMessage"]="Incorrect Username/Password";
      Redirect_to("index.php");
    }
  }


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script src="jquery.email-autocomplete.min.js"></script>
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
  <link rel="stylesheet" href="Css/Styles.css">
  <title>Login</title>
  
	</style>
<style>
.copyright {
    background-color: #f3f4f4;
}

.eac-sugg {
		  color: #ccc;
		}

.form-control1 {
    display: block;
    width: 240%;
    height: calc(2.25rem + 2px);
    padding: .375rem .75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: .25rem;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;


.copyright {
    padding: 30px 0;
    text-align: center;
    background-color: #e7f7fa;
    font-size: 16px;
}

</style>


</head>


<body>
  <!-- NAVBAR -->
  <div style="height:10px; background:#27aae1;"></div>
  <nav class="navbar navbar-expand-lg bg-light">
    <div class="container">
      <a class="navbar-brand text-dark"> <B> CMS </B></a>
      
      <div class="collapse navbar-collapse" id="navbarcollapseCMS">
      </div>
    </div>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item"><a href="Register.php" class="nav-link text-dark">
        <i class="fa fa-user-plus"></i></i> Signup</a></li>
      </ul>
  </nav>
    <div style="height:10px; background:#27aae1;"></div>
    <!-- NAVBAR END -->
    <!-- HEADER -->
	
      <div class="container">
        <div class="row">
          <div class="col-md-12">
          </div>
        </div>
      </div>
    </header>
    <!-- HEADER END -->
    <!-- Main Area Start -->
    <section class="container py-2 mb-4">
      <div class="row">
        <div class="offset-sm-3 col-sm-6" style="min-height:500px;">
          <br><br><br>
          <?php
           echo ErrorMessage();
           echo SuccessMessage();
           ?>
          <div class="card bg-primary text-light">
            <div class="card-header">
              <h4><center>Welcome User<center></h4>
              </div>
              <div class="card-body bg-light">
              <form class="" action="index.php" method="post">
                <div class="form-group">
                  <label for="username"><span class="FieldInfo text-dark">Email:</span></label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text text-dark "> <i class="fas fa-user"></i> </span>
                    </div>
                    <input type="text" class="form-control"  autocomplete="FALSE"  placeholder="Email id"name="Username" id="username" value="">
                    <script>
                      $("#username").keydown(function(e) {
                      if (e.keyCode == 32) {
                      return false;
                      }
                      });

                    </script>

                    
                    <!-- <script>
                    $("#username").emailautocomplete({
                      suggClass: "eac-sugg",
                      domains: ["yahoo.com" ,"hotmail.com" ,"gmail.com" ,"me.com" ,"aol.com" ,"mac.com" ,"live.com" ,"comcast.net" ,"googlemail.com" ,"msn.com" ,"hotmail.co.uk" ,"yahoo.co.uk" ,"facebook.com" ,"verizon.net" ,"sbcglobal.net" ,"att.net" ,"gmx.com" ,"outlook.com" ,"icloud.com"]
                    });
                    </script> -->

                  </div>
                </div>
                <div class="form-group">
                  <label for="password"><span class="FieldInfo text-dark">Password:</span></label>
                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                      <span class="input-group-text text-dark "> <i class="fas fa-lock"></i> </span>
                    </div>
                    <input type="password" class="form-control" placeholder="Password" name="Password" id="password" value="" maxlength="10">
                  </div>
                </div>
				
                <input type="submit" name="Submit" class="btn bg-primary btn-block text-light" value="Login">
			
			  </form>

            </div>

          </div>

        </div>

      </div>

    </section>
    <!-- Main Area End -->
    <!-- FOOTER -->
    <div class="copyright">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
					  <center><p class="lead text-dark"><B>Develop By Ravi & Shubh Bros. <span id="year"></span> &copy; ---All Right Reserved.</B></p></center>
				</div>
            </div>
        </div>
    </div>
    <!-- FOOTER END-->

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
<script>
  $('#year').text(new Date().getFullYear());
</script>
</body>
</html>
