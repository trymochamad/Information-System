<?php
session_start();
include "Conf.php";
$message = null;
if($_SERVER["REQUEST_METHOD"] == "POST") {
  if(!isset($_POST["username"])) {
    $message = "Harap masukan username";
  }
  elseif(!isset($_POST["password"])) {
    $message = "Harap masukan password dengan benar";
  }
  else {
    $username = $_POST["username"];
    $password = $_POST["password"];
    include "DBConnector.php";
    $pegawai = getPegawai($username);
    if(is_null($pegawai)) {
      $message = "Username tidak ditemukan";
    }
    elseif($_POST["password"] === $pegawai["password"]) {
      $_SESSION["username"] = $username;
      $_SESSION["jenis"] = $pegawai["jenis"];
      if($pegawai["jenis"] === "operasional")
        header("Location: DataPenjualan.php");
      else
        header("Location: DataBahan.php");
      exit;
    }
    else {
      $message = "Password masukan tidak benar";
    }
  }
}
else {
  if(isset($_SESSION["username"])) {
    include "DBConnector.php";
    $pegawai = getPegawai($_SESSION["username"]);
    if(!is_null($pegawai)) {
      if($pegawai["jenis"] === "operasional")
        header("Location: DataPenjualan.php");
      else
        header("Location: DataBahan.php");
      exit;
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/js/umd/collapse.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css"></script>

  <script>
    $(document).ready(function() {

      $(window).scroll(function () {
        //if you hard code, then use console
        //.log to determine when you want the
        //nav bar to stick.
        console.log($(window).scrollTop())
        if ($(window).scrollTop() > 500) {
          $('#nav_bar').addClass('navbar-fixed-top');
        }
        if ($(window).scrollTop() < 501) {
          $('#nav_bar').removeClass('navbar-fixed-top');
        }
      });
    });
  </script>


  <style>
    .carousel-inner > .item > img,
    .carousel-inner > .item > a > img {
      width: 100%;
      margin: auto;
    }
  </style>

</head>
<body>

 <center>
  <div id="myCarousel" class="carousel slide" data-ride="carousel"style="background-color: #3c4192">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
      <li data-target="#myCarousel" data-slide-to="3"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
      <div class="item active">
        <img src="image/2.JPG" alt="Chania">
      </div>

      <div class="item">
        <img src="image/3.JPG" alt="Flower">
      </div>

      <div class="item">
        <img src="image/4.JPG" alt="Flower">
      </div>
    </div>

    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div>

  <div id="nav_bar" class="navbar navbar-default" role="navigation" style="background-color: #3d3d3d; height: 100px">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>

    </div>
    <div class="collapse navbar-collapse navbar-ex1-collapse">
      <ul class="nav navbar-nav navbar-header " style="background-color: #3d3d3d;font-size: xx-large">
        <li><a href="index.php">Login</a></li>
      </ul>
    </div>
  </div>
</center>

<div class="container-fluid maxedwidth">
 <div class="row">

   <form role="form" action="" method="POST">
     <div class="col-sm-18">
       <div style="height: 100px">
       </div>
       <div style="font-size: x-large; color: #3d3d3d !important;" class=" text-center">
         Username
       </div>

       <center>
         <input type="text" class="form-control" id="username" name="username" style="width: 450px">
       </center>
       <br><br>
       <div style="font-size: x-large; color: #3d3d3d !important;" class=" text-center">
         Password
       </div>

       <center>
         <input type="password" class="form-control" id="password" name="password" style="width: 450px"><br><br><br>
       </center>

       <div class="row">
         <div class="col-sm-7">
         </div>
         <button type="submit" class="btn-xlarge">Entry</button>
       </div>

     </div>
   </form>

 </div>
</div><br>


<center>
  <footer style="background-color: #3d3d3d" class="container-fluid text-center">
    <div class="container">
      <br>
      <div class="row">
        <div class="col-sm-4">
          - - -
        </div>
        <div class="col-sm-4">
          - - -
        </div>
        <div class="col-sm-4">
          - - -
        </div>
      </div>
    </div>
    <br>
    <br>
    <br>
    <div class="container" style="height: 120px; font-size: xx-large">
     <a href="index.php">Chez Nouz Cafe</a>
   </div>
 </footer>
</center>>
<?php
if(!is_null($message))
  echo "<script type='text/javascript'>alert('".$message."')</script>";
?>
</body>
</html>