<?php
    // session_start();

    // include "Conf.php";

    // if(!isset($_SESSION["login"])) {
    //   header("Location: index.php");
    //   exit;
    // }
    // if($_SESSION["login"] !== $session_login) {
    //   header("Location: index.php");
    //   exit;
    // }
    // include("DBConnector.php");
$penjualan = array(array("id"=>1, "username"=>"iafir", "id_produk"=>1, "nama_produk" => "Nasi", "tanggal"=>"15 Maret 1996", "harga_terjual"=>5000),
    array("id"=>2, "username"=>"iafir", "id_produk"=>2, "nama_produk" => "Air Mineral", "tanggal"=>"15 Maret 1996", "harga_terjual"=>2000));
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
                    <li><a href="LaporanPenjualan.php">Laporan Penjualan</a></li>
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
                        <h2>Laporan Penjualan</h2>
                        <p>berikut adalah data penjualan</p>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Pegawai</th>
                                    <th>Produk</th>
                                    <th>Tanggal</th>
                                    <th>Harga Terjual</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $total = 0 ?>
                                <?php foreach($penjualan as $jual): ?>
                                    <tr>
                                        <td><?=$jual["username"]?></td>
                                        <td><?=$jual["id_produk"]?> - <?=$jual["nama_produk"]?></td>
                                        <td><?=$jual["tanggal"]?></td>
                                        <td>Rp <?=$jual["harga_terjual"]?></td>
                                    </tr>
                                <?php $total += $jual["harga_terjual"];
                                endforeach; ?>
                                <tr>
                                   <td><b>Total</b></td>
                                    <td></td>
                                    <td></td>
                                    <td>Rp <?=$total?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <button id="cetak" onclick="cetak()" class="text-black">cetak</button>
                </div>
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
        function cetak() {

        }
    </script>
</body>
</html>