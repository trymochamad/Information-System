<?php
    include "Authenticator.php";
    authPengadaan();

    $username = $_SESSION["username"];
    $message = null;
    $produk = array();
    $produk['nama'] = '';
    $produk['jenis'] = '';
    $produk['harga'] = '0';
    $bahan = getAllBahan();
    $komposisi = array();
    $id = -1;
    if($_SERVER["REQUEST_METHOD"] == "GET") {
        if(isset($_GET["id"])) 
            $id = preprocess($_GET['id']);
    }
    if($id != -1) {
        $produk = getProduk($id);
        if(is_null($produk))
            $id = -1;
        $komposisi = getKomposisi($id);
    }
    foreach ($bahan as $key => $value) {
        if(isset($komposisi[$value['id']]))
            $value['komposisi'] = $komposisi[$value['id']];
        else
            $value['komposisi'] = 0;
        $bahan[$key] = $value;
    }
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

    <style>
        .carousel-inner > .item > img,
        .carousel-inner > .item > a > img {
            width: 100%;
            margin: auto;
        }
    </style>
    <style>
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
                    <li><a href="KomposisiProduk.php?id=<?=$id?>">Komposisi Produk</a></li>
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
                        <?php if($id < 0): ?>
                        <h2>Produk Baru</h2>
                        <?php else: ?>
                        <h2>Edit Produk Dengan ID : <?=$id?></h2>
                        <?php endif ?>
                            <br />
                            <form id="overlay_form" method="POST" action="DataProduk.php">
                                <input type="hidden" name="action" value="<?=($id < 0 ? 'add' : 'edit')?>"/>
                                <input type="hidden" id="id" name="id" value="<?=$id?>"/>
                                <div class="row">
                                    <div class="col-sm-3 text-right" style="color: #3d3d3d !important;font-size: large">
                                    Nama Produk
                                    </div>
                                    <div class="col-sm-9">
                                    <input type="text" class="form-control" id="nama" name="nama" value="<?=$produk['nama']?>" style="width: 450px"><br>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3 text-right" style="color: #3d3d3d !important;font-size: large">
                                    Jenis
                                    </div>
                                    <div class="col-sm-9">
                                    <input type="text" class="form-control" id="jenis" name="jenis" value="<?=$produk['jenis']?>" style="width: 450px"><br>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3 text-right" style="color: #3d3d3d !important;font-size: large">
                                    Harga
                                    </div>
                                    <div class="col-sm-9">
                                    <input type="text" class="form-control" id="harga" name="harga" value="<?=$produk['harga']?>" style="width: 450px"><br>
                                    </div>
                                </div>
                                <p>Berikut adalah komposisi bahan baku yang diperlukan untuk membuat produk ini</p>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>ID Bahan</th>
                                            <th>Nama Bahan</th>
                                            <th>Jumlah Dibutuhkan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($bahan as $item) : ?>
                                        <tr>
                                            <td><?=$item['id']?></td>
                                            <td><?=$item['nama']?></td>
                                            <td><input type="text" class="form-control" name="jumlah<?=$item['id']?>" value="<?=$item['komposisi']?>"/></td>
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
     <?php
        if(!is_null($message))
          echo "<script type='text/javascript'>alert('".$message."')</script>";
     ?>
</body>
</html>