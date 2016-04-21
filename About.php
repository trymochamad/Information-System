<?php
    include "Authenticator.php";
    $jenis = authPegawai();
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
                        <li><a href="index.php">About</a></li>
                    </ul>
                </div>
            </div>




        </center>

       <div class="container-fluid maxedwidth">
           <div class="row">
                <div class="col-sm-4 text-center">
                    <div class="insidecard" style="height: 600px !important;font-size: x-large">
                        <br>
                    <?php if($jenis == "operasional") : ?>
                        <a href="DataPenjualan.php">Data Penjualan</a><br><br>
                        <a href="LaporanPenjualan.php">Laporan Penjualan</a><br><br>
                        <a href="Statistik.php">Statistik</a><br><br>
                    <?php else : ?>
                        <a href="DataBahan.php">Data Bahan</a><br><br>
                        <a href="DataPesananBahan.php">Data Pesanan Bahan</a><br><br>
                        <a href="DataProduk.php">Data Produk</a><br><br>
                    <?php endif; ?>
                        <br><br>
                        <br><br>
                        <a href="Help.php" style="alignment: bottom">Help</a><br><br>
                        <a href="About.php">About</a><br><br>
                        <a href="LogOut.php">Log Out</a>
                    </div>
                </div>


               <div class="col-sm-7">
                   <div style="height: 230px">
                   </div>
                   <div style="font-size: x-large; color: #3d3d3d !important;" class=" text-center">
                       Aplikasi ini dibangun untuk memudahkan pekerjaan Chez Nous Cafe.
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
        </center>>
</body>
</html>