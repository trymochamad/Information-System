<?php
    include "Authenticator.php";
    authOperasional();

    $username = $_SESSION["username"];
    $message = null;
    $action = null;
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $action = preprocess($_POST["action"]);
    }
    if(is_null($message) && !is_null($action)) {
        $id = preprocess($_POST["id"]);
        if($action == "delete") {
            deletePenjualan($id, $username);
        }
        else {
            $id_produk = preprocess($_POST["id_produk"]);
            $tanggal = preprocess($_POST["tanggal"]);
            $harga = preprocess($_POST["harga"]);
            if($action == "add") {
                $message = addPenjualan($_SESSION["username"], $id_produk, $tanggal, $harga);
                if(is_null($message))
                    $message = "Penambahan penjualan berhasil";
            }
            elseif ($action == "edit") {
                $message = editPenjualan($id, $_SESSION["username"], $id_produk, $tanggal, $harga);
                if(is_null($message))
                    $message = "Pengeditan penjualan berhasil";
            }
        }
    }
    function preprocess($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $penjualan = getAllPenjualan();
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
                    <li><a href="DataPenjualan.php">Data Penjualan</a></li>
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
                        <h2>Penjualan</h2>
                        <p>Untuk menambahkan data penjualan klik <a href="#" id="pop" >tambah baru</a>
                            <br />
                            <form id="overlay_form" style="display:none" method="POST" action="#">
                                <h2 id="judul_form">Penjualan Baru</h2>
                                <input type="hidden" id="id_penjualan" name="id" value="-1">
                                <input type="hidden" id="action" name="action" value="add">
                                <div class="row">
                                 <div class="col-sm-3 text-right" style="color: #3d3d3d !important;font-size: large">
                                     Produk
                                 </div>

                                   <div class="col-sm-9">
                                       <select type="text" class="form-control" id="id_produk" name="id_produk" style="width: 450px" onchange="changeSelected()">
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
                                     <input type="text" class="form-control" id="tanggal" name="tanggal" style="width: 450px"><br>
                                 </div>
                             </div>

                             <div class="row">
                                 <div class="col-sm-3 text-right" style="color: #3d3d3d !important;font-size: large">
                                     Harga
                                 </div>
                                 <div class="col-sm-9">
                                     <input type="text" class="form-control" id="harga" name="harga" style="width: 450px"><br>
                                 </div>
                             </div>
                             <center>
                                <input type="submit" id="btnSubmit" value="tambahkan" />  
                                <a href="#" id="close" >batal</a>
                            </center>
                        </form>
                        <p>berikut adalah data penjualan</p>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Pegawai</th>
                                    <th>Produk</th>
                                    <th>Tanggal</th>
                                    <th>Harga Terjual</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php foreach($penjualan as $jual): ?>
                                    <tr>
                                        <td><?=$jual["id"]?></td>
                                        <td id='pegawai<?=$jual["id"]?>'><?=$jual["username"]?></td>
                                        <td id='produk<?=$jual["id"]?>'><?=$jual["id_produk"]?> - <?=$jual["nama_produk"]?></td>
                                        <td id='tanggal<?=$jual["id"]?>'><?=$jual["tanggal"]?></td>
                                        <td id='harga<?=$jual["id"]?>'>Rp <?=$jual["harga_terjual"]?></td>
                                        <td>
                                            <?php if($jual["username"] == $username): ?>
                                            <a href="#"><img src='image/edit.jpg' class='btnEdit' onclick='edit(<?=$jual["id"]?>)' /></a>
                                            <form action="#" method="POST" onsubmit="return confirm('Apakah Anda yakin akan menghapus penjualan dengan ID <?=$jual["id"]?>'     );">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="id" value='<?=$jual["id"]?>'>
                                            <input type="image" src='image/delete.jpg' class='btnDelete'/>
                                            </form>
                                            <?php endif; ?>
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
        <script type="text/javascript">

            $(document).ready(function(){
            //open popup
            $("#pop").click(function(){
                document.getElementById("judul_form").innerHTML = "Penjualan Baru";
                document.getElementById("action").value = "add";
                document.getElementById("id_penjualan").value = -1;
                document.getElementById("id_produk").selectedIndex = -1;
                var d = new Date();
                document.getElementById("tanggal").value = ""+d.getFullYear()+"-"+(d.getMonth()+1) + "-"+(d.getDate());
                document.getElementById("harga").value = "";
                document.getElementById("btnSubmit").value = "tambahkan";
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
                left: 0,
                top: 0,
                position:'absolute'
            });
        }
        //maintain the popup at center of the page when browser resized
        $(window).bind('resize',positionPopup);
        function edit(id) {
            var produk = [];
            <?php foreach ($produk as $item) {
                    echo 'produk.push("'.$item["id"].' - '.$item['nama'].'");';
                }
            ?>
            document.getElementById("judul_form").innerHTML = "Edit Data Penjualan (ID : "+id+")";
            document.getElementById("action").value = "edit";
            document.getElementById("id_penjualan").value = id;
            document.getElementById("id_produk").selectedIndex = produk.indexOf(document.getElementById("produk"+id).innerHTML);
            document.getElementById("tanggal").value = document.getElementById("tanggal"+id).innerHTML;
            document.getElementById("harga").value = document.getElementById("harga"+id).innerHTML.substring(3);
            document.getElementById("btnSubmit").value = "ubah";
            $("#overlay_form").fadeIn(1000);
            positionPopup();
        }
        function changeSelected() {
            var produk = [];
            var id = 0;
            <?php
                $x = 0; 
                foreach ($produk as $item) {
                    echo 'produk['.$x.'] = '.$item["harga"].';';
                    $x++;
                }
            ?>
            var selectBox = document.getElementById("id_produk");
            document.getElementById("harga").value = produk[selectBox.selectedIndex];
        }
    </script>

     <?php
        if(!is_null($message))
          echo "<script type='text/javascript'>alert('".$message."')</script>";
     ?>
</body>
</html>