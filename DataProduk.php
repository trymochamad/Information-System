<?php
    include "Authenticator.php";
    authPengadaan();

    $username = $_SESSION["username"];
    $message = null;
    $action = null;
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $action = preprocess($_POST["action"]);
    }
    if(is_null($message) && !is_null($action)) {
        $id = preprocess($_POST["id"]);
        if($action == "delete") {
            $message = deleteProduk($id);
            if(is_null($message))
                    $message = "Penghapusan produk berhasil";
        }
        else {
            $nama = preprocess($_POST['nama']);
            $jenis = strtolower(preprocess($_POST['jenis']));
            $harga = preprocess($_POST['harga']);
            $komposisi = array();
            foreach ($_POST as $key => $value) if(substr($key, 0, 6) == "jumlah") {
                $komposisi[substr($key, 6)] = preprocess($value);
            }
            if($action == "add") {
                $message = addProduk($nama, $jenis, $harga, $komposisi);
                if(is_null($message))
                    $message = "Produk baru berhasil disimpan";

            }
            else {
                $message = editProduk($id, $nama, $jenis, $harga, $komposisi);
                if(is_null($message))
                    $message = "Produk ".$_POST['id']." berhasil disimpan";
            }
        }
    }
    function preprocess($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $produk = getAllProduk();
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
                    <li><a href="DataProduk.php">Data Produk</a></li>
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
                        <h2>Produk</h2>
                        <p>Untuk menambahkan data produk baru klik <a href="KomposisiProduk.php?id=-1" id="pop" >tambah baru</a>
                        <br />
                        <p>berikut adalah data produk</p>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>Jenis</th>
                                    <th>Harga</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php foreach($produk as $item): ?>
                                    <tr>
                                        <td><?=$item["id"]?></td>
                                        <td id='nama<?=$item["id"]?>'><?=$item["nama"]?></td>
                                        <td id='jenis<?=$item["id"]?>'><?=$item["jenis"]?></td>
                                        <td id='harga<?=$item["id"]?>'><?=$item["harga"]?></td>
                                        <td>
                                            <a href="KomposisiProduk.php?id=<?=$item["id"]?>"><img src='image/edit.jpg' class='btnEdit' onclick='edit(<?=$item["id"]?>)' /></a>
                                            <form action="#" method="POST" onsubmit="return confirm('Apakah Anda yakin akan menghapus produk dengan ID <?=$item["id"]?>'     );">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="id" value='<?=$item["id"]?>'>
                                            <input type="image" src='image/delete.jpg' class='btnDelete'/>
                                            </form>
                                        </td>
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
     <?php
        if(!is_null($message))
          echo "<script type='text/javascript'>alert('".$message."')</script>";
     ?>
</body>
</html>