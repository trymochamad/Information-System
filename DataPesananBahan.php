<?php
    include "Authenticator.php";
    authPengadaan();

    $username = $_SESSION["username"];
    $message = null;
    $action = null;
    $bahan = getAllBahan();
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $action = preprocess($_POST["action"]);
    }
    if(is_null($message) && !is_null($action)) {
        if($action == "verifikasi") {
            $message = verifyPesanan(preprocess($_POST["id"]));
            if(is_null($message))
                $message = "Verifikasi ".$_POST["id"]." berhasil";
        }
        else {
            $porsi = array();
            foreach ($_POST as $key => $value) if(substr($key, 0, 6) == "jumlah") {
                $item["jumlah"] = $value;
                $item["id_bahan"] = substr($key, 6);
                array_push($porsi, $item);
            }
            if($action == "add") {
                $tanggal = date("Y-m-d");
                $message = addPesananBahan($username, $tanggal, $porsi);
                if(is_null($message))
                    $message = "Pesanan bahan baru berhasil disimpan";       
            }
            else {
                $message = editPorsiPesan($_POST['id'], $porsi);
                if(is_null($message))
                    $message = "Pesanan bahan ".$_POST['id']." berhasil disimpan";       
            }
        }
    }
    function preprocess($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $pesanan = getPesananBahan();
    if($pesanan)
        $porsi = getPorsiPesan($pesanan['id']);
    else
        $porsi = calculatePorsiPesan();
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
            /*position: absolute;*/
/*            border: 5px solid gray;
            padding: 10px;
            background: white;
*/            /*width: 700px;*/
            /*height: 300px;*/
        }
        #pesan{
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
                    <li><a href="DataPesananBahan.php">Data Pesanan Bahan</a></li>
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
                    <a href="DataProduk.php">Data Produk</a><br><br>
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
                        <?php if(is_null($pesanan)): ?>
                            <p>Anda tidak punya pesanan bahan, untuk melakukan pesanan bahan baru klik <a href="#" id="pesan" >pesan baru</a></p>
                            <br />
                            <form id="overlay_form" style="display:none" method="post">
                                <h3 id="judul_form">Pesanan Bahan Baku Baru</h3>
                                <input type="hidden" name="action" value="add"/>
                                <input type="hidden" id="id_pesanan" name="id" value="-1"/>
                        <?php else: ?>
                            <p>Anda mempunyai pesanan bahan yang belum diverifikasi, jika pesanan sudah sampai klik 
                            <form method="post">
                                <input type="hidden" name="action" value="verifikasi"/>
                                <input type="hidden" id="id_pesanan" name="id" value="<?=$pesanan['id']?>"/>
                                <input type="submit" id="verifikasi" value="verifikasi" >
                            </form></p>
                            <br />
                            <form id="overlay_form" method="post">
                                <h3 id="judul_form">Pesanan Bahan Baku Yang Belum Diverifikasi</h3>
                                <input type="hidden" name="action" value="edit"/>
                                <input type="hidden" id="id_pesanan" name="id" value="<?=$pesanan['id']?>"/>
                        <?php endif ?>

                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>ID Bahan</th>
                                            <th>Nama Bahan</th>
                                            <th>Batas Minimum</th>
                                            <th>Tersedia</th>
                                            <th>Dipesan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($porsi as $item) : ?>
                                        <tr>
                                            <td><?=$item['id']?></td>
                                            <td><?=$item['nama']?></td>
                                            <td><?=$item['batas_minimum']?></td>
                                            <td><?=$item['tersedia']?></td>
                                            <td><input type="text" class="form-control" name="jumlah<?=$item['id']?>" value="<?=$item['dipesan']?>"/></td>
                                        </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                                 <center>
                                    <input type="submit" value="simpan" />  
                                </center>
                            </form>
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
            $("#pesan").click(function(){
                $("#overlay_form").fadeIn(1000);
            });
        });
    </script>
     <?php
        if(!is_null($message))
          echo "<script type='text/javascript'>alert('".$message."')</script>";
     ?>
</body>
</html>