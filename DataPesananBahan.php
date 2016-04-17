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
$pesanan = array(array("id"=>1, "username"=>"try", "tanggal"=>"15/03/2016", "status" => "selesai"),
    array("id"=>2, "username"=>"try", "tanggal"=>"15/04/2016", "status" => "belum"));
$produk = array(array("id"=>1, "nama"=>"Nasi"), array("id"=>2, "nama"=>"Air Mineral"));
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
        #pop{
            /*display: block;*/
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
                    <li><a href="DataBahan.php">Data Pesanan Bahan</a></li>
                </ul>
            </div>
        </div>




    </center>

    <div class="container-fluid maxedwidth">
        <div class="row">

            <div class="col-sm-4 text-center">
                <div class="insidecard" style="height: 600px !important;font-size: x-large">
                    <br>
                    <a href="DataBahan.php">Data Bahan</a><br><br>
                    <a href="DataPesananBahan.php">Data Pesanan Bahan</a><br><br>
                    <a href="DataMakanan.php">Data Makanan</a><br><br>
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
                        <h2>Pesanan Bahan Baku</h2>
                        <p>Untuk menambahkan Data Pesanan Bahan baku klik <a href="#" id="pop" >tambah baru</a></p>
                            <br />
                            <form id="overlay_form" style="display:none">
                                <h2 id="judul_form">Bahan Baku Baru</h2>
                                <input type="hidden" id="id_penjualan" name="id" value="-1"/>
                                <div class="row">
                                 <div class="col-sm-3 text-right" style="color: #3d3d3d !important;font-size: large">
                                     Produk
                                 </div>

                                   <div class="col-sm-9">
                                       <select type="text" class="form-control" id="Status_User" name="Status" style="width: 450px">
                                        <?php foreach ($produk as $item) : ?> 
                                        <option value="<?=$item["id"]?>"><?=$item["id"]?> - <?=$item["nama"]?></option>
                                        <?php endforeach ?>
                                        </select>
                                   <br>
                                   </div>
                             </div>

                             <div class="row">
                                 <div class="col-sm-3 text-right" style="color: #3d3d3d !important;font-size: large">
                                     Tanggal
                                 </div>
                                 <div class="col-sm-9">
                                     <input type="text" class="form-control" id="tanggal" style="width: 450px"><br>
                                 </div>
                             </div>

                             <div class="row">
                                 <div class="col-sm-3 text-right" style="color: #3d3d3d !important;font-size: large">
                                     Harga
                                 </div>
                                 <div class="col-sm-9">
                                     <input type="text" class="form-control" id="harga" style="width: 450px"><br>
                                 </div>
                             </div>
                             <center>
                                <input type="button" value="tambahkan" />  
                                <a href="#" id="close" >batal</a>
                            </center>
                        </form>
                        <p>berikut adalah Data Pesanan Bahan baku</p>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Pegawai</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php foreach($pesanan as $pesan): ?>
                                    <tr>
                                        <td><?=$pesan["id"]?></td>
                                        <td><?=$pesan["username"]?></td>
                                        <td><?=$pesan["tanggal"]?></td>
                                        <td><?=$pesan["status"]?></td>
                                        <td><a href="#"><img src='image/edit.jpg' class='btnEdit' onclick='edit()' /></a>
                                            <a href='delete_jual.php?id=<?=$jual["id"]?>'><img src='image/delete.jpg' class='btnDelete'/></a></td>
                                        </tr>
                                    <?php endforeach; ?>

                                </tbody>
                            </table>
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

            $(document).ready(function(){
            //open popup
            $("#pop").click(function(){
                document.getElementById("judul_form").innerHTML = "Penjualan Baru";
                $("#overlay_form").fadeIn(1000);
                positionPopup();
            });

            //close popup
            $("#close").click(function(){
                $("#overlay_form").fadeOut(500);
            });
        });

        //position the popup at the center of the page
        function positionPopup(){
            if(!$("#overlay_form").is(':visible')){
                return;
            }
            $("#overlay_form").css({
                left: 0,//  ($(window).width() - $('#overlay_form').width()) / 2,
                top: 0,//($(window).height() - $('#overlay_form').height()) / 7,
                position:'absolute'
            });
        }
        //maintain the popup at center of the page when browser resized
        $(window).bind('resize',positionPopup);
        function edit() {
            document.getElementById("judul_form").innerHTML = "Edit Data Penjualan";
            $("#overlay_form").fadeIn(1000);
            positionPopup();
        }
    </script>
</body>
</html>