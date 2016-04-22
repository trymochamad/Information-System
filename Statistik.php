<?php
  include "Authenticator.php";
  authOperasional();
  $jenis = "semua";
  $awal = date("Y-m-d");
  $akhir = date("Y-m-d");
  if($_SERVER["REQUEST_METHOD"] == "POST") {
    $jenis = preprocess($_POST['jenis']);
    $awal = preprocess($_POST['awal']);
    $akhir = preprocess($_POST['akhir']);
  }
  $statistik = getStat($jenis, $awal, $akhir);
  $jenisproduk = getJenisProduk();
  function preprocess($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
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
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.0.0/Chart.js"></script>

  <style>
    .carousel-inner > .item > img,
    .carousel-inner > .item > a > img {
      width: 100%;
      margin: auto;
    }
  </style>
  <style>
    #overlay_form{
      position: absolute;
      border: 5px solid gray;
      padding: 10px;
      background: white;
      width: 700px;
      height: 300px;
    }
    #cetak{
      display: block;
      border: 1px solid gray;
      width: 65px;
      padding: 5px;
      border-radius: 5px;
      text-decoration: none;
      margin: 0 auto;
    }
  </style>

</head>
<body>

  <center>

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
          <li><a href="Statistik.php">Statistik</a></li>
        </ul>
      </div>
    </div>




  </center>

  <div class="container-fluid maxedwidth">
    <div class="row">

      <div class="col-sm-4 text-center">
        <div class="insidecard" style="height: 600px !important;font-size: x-large">
          <br>
          <a href="DataPenjualan.php">Data Penjualan</a><br><br>
          <a href="LaporanPenjualan.php">Laporan Penjualan</a><br><br>
          <a href="Statistik.php">Statistik</a><br><br>
          <br><br>
          <br><br>
          <a href="Help.php" style="alignment: bottom">Help</a><br><br>
          <a href="About.php">About</a><br><br>
          <a href="LogOut.php">Log Out</a>

        </div>
      </div>

      <div class="col-sm-8">
        <div class="row">
          <div class="text-black container" style="width:100%">
            <h2>Statistik Penjualan</h2>
            <form method="POST">

             <div class="row">
               <div class="col-sm-3 text-right" style="color: #3d3d3d !important;font-size: large">
                Jenis
              </div>
             <div class="col-sm-9">
                 <select type="text" class="form-control" id="jenis" name="jenis" style="width: 450px">
                  <option value="semua">semua</option>
                  <?php foreach ($jenisproduk as $item) : ?>
                  <option value="<?=$item?>" <?=($jenis==$item)? "selected" : ""?>><?=$item?></option>
                  <?php endforeach ?>
                  </select>
             <br>
             </div>
           </div>

           <div class="row">
             <div class="col-sm-3 text-right" style="color: #3d3d3d !important;font-size: large">
              Rentang Waktu
             </div>
             <div class="col-sm-9 text-black">
             <input type="text" class="form-control" id="awal" name="awal" value="<?=$awal?>" style="width: 450px">
             s.d.
             <input type="text" class="form-control" id="akhir" name="akhir" value="<?=$akhir?>" style="width: 450px"><br><br>
             </div>
           </div>
           <div class="row">
             <div class="col-sm-9">
             </div>
             <div class="col-sm-1">
               <button type="submit" class="btn-xlarge">SHOW</button>
             </div>
           </div>
         </form>
         <br><br>
         <h3>Grafik Penjualan</h3>
         <canvas id="myChart" width="100%" height="60%"></canvas>
       </div>
     </div>
   </div>
  </div>
</div><br>

<center>
  <footer style="background-color: #3d3d3d" class="container-fluid text-center">
    <div class="container">
      <br>
      <div class="row">
        <div class="col-sm-3">
          - - -
        </div>
        <div class="col-sm-3">
          - - -
        </div>
        <div class="col-sm-3">
          - - -
        </div>
        <div class="col-sm-3">
          - - -
        </div>
      </div>
    </div>
    <br>
    <br>
    <br>
    <div class="container" style="height: 120px; font-size: xx-large">
      <a href="index.php">Chez Nous Cafe</a>
    </div>
  </footer>
</center>
<script type="text/javascript">

    var ctx = document.getElementById("myChart").getContext("2d");
    var data = {
      labels: [
        <?php foreach ($statistik as $key => $value)
          echo "'".$key."', ";
        ?>
      ],
      datasets: [
        {
          label: "Jumlah Penjualan",

          // The properties below allow an array to be specified to change the value of the item at the given index
          // String  or array - the bar color
          backgroundColor: "rgba(52,201,250,1)",

          // String or array - bar stroke color
          borderColor: "rgba(220,220,220,1)",

          // Number or array - bar border width
          borderWidth: 1,

          // String or array - fill color when hovered
          hoverBackgroundColor: "rgba(52,201,250,0.5)",

          // String or array - border color when hovered
          hoverBorderColor: "rgba(220,220,220,1)",

          // The actual data
          data: [
          <?php foreach ($statistik as $key => $value)
            echo $value.', ';
          ?>
        ],

          // String - If specified, binds the dataset to a certain y-axis. If not specified, the first y-axis is used.
          yAxisID: "y-axis-0",
        }
      ]
    };
    var myBarChart = new Chart(ctx, {
      type: 'bar',
      data: data,
      options:  {
        scales: {
            xAxes: [{
              stacked: true
            }],
            yAxes: [{
              stacked: true
            }]
        }
      }
    });
</script>
</body>
</html>