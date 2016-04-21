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
            $message = deleteBahan($id);
            if(is_null($message))
                    $message = "Penghapusan bahan baku berhasil";
        }
        else {
            $nama = preprocess($_POST["nama"]);
            $tersedia = preprocess($_POST["tersedia"]);
            $batas_minimum = preprocess($_POST["batas_minimum"]);
            if($action == "add") {
                $message = addBahan($nama, $tersedia, $batas_minimum);
                if(is_null($message))
                    $message = "Penambahan bahan baku berhasil";
            }
            elseif ($action == "edit") {
                $message = editBahan($id, $nama, $tersedia, $batas_minimum);
                if(is_null($message))
                    $message = "Pengeditan bahan baku berhasil";
            }
        }
    }
    function preprocess($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    $bahan_baku = getAllBahan();
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
                    <li><a href="DataBahan.php">Data Bahan</a></li>
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
                        <h2>Bahan Baku</h2>
                        <p>Untuk menambahkan data bahan baku klik <a href="#" id="pop" >tambah baru</a>
                            <br />
                            <form id="overlay_form" style="display:none" method="POST" action="#">
                                <h2 id="judul_form">Bahan Baku Baru</h2>
                                <input type="hidden" id="id_bahan" name="id" value="-1">
                                <input type="hidden" id="action" name="action" value="add">

                             <div class="row">
                                 <div class="col-sm-3 text-right" style="color: #3d3d3d !important;font-size: large">
                                     Nama Bahan
                                 </div>
                                 <div class="col-sm-9">
                                     <input type="text" class="form-control" id="nama" name="nama" style="width: 450px"><br>
                                 </div>
                             </div>

                             <div class="row">
                                 <div class="col-sm-3 text-right" style="color: #3d3d3d !important;font-size: large">
                                     Jumlah Tersedia
                                 </div>
                                 <div class="col-sm-9">
                                     <input type="text" class="form-control" id="tersedia" name="tersedia" style="width: 450px"><br>
                                 </div>
                             </div>

                             <div class="row">
                                 <div class="col-sm-3 text-right" style="color: #3d3d3d !important;font-size: large">
                                     Batas Minimum
                                 </div>
                                 <div class="col-sm-9">
                                     <input type="text" class="form-control" id="batas_minimum" name="batas_minimum" style="width: 450px"><br>
                                 </div>
                             </div>
                             <center>
                                <input type="submit" id="btnSubmit" value="tambahkan" />  
                                <a href="#" id="close" >batal</a>
                            </center>
                        </form>
                        <p>berikut adalah data bahan baku</p>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>Jumlah Tersedia</th>
                                    <th>Batas Minimum</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>

                                <?php foreach($bahan_baku as $bahan): ?>
                                    <tr>
                                        <td><?=$bahan["id"]?></td>
                                        <td id='nama<?=$bahan["id"]?>'><?=$bahan["nama"]?></td>
                                        <td id='tersedia<?=$bahan["id"]?>'><?=$bahan["tersedia"]?></td>
                                        <td id='batas_minimum<?=$bahan["id"]?>'><?=$bahan["batas_minimum"]?></td>
                                        <td>
                                            <a href="#"><img src='image/edit.jpg' class='btnEdit' onclick='edit(<?=$bahan["id"]?>)' /></a>
                                            <form action="#" method="POST" onsubmit="return confirm('Apakah Anda yakin akan menghapus bahan baku dengan ID <?=$bahan["id"]?>'     );">
                                            <input type="hidden" name="action" value="delete">
                                            <input type="hidden" name="id" value='<?=$bahan["id"]?>'>
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
        <script type="text/javascript">

            $(document).ready(function(){
            //open popup
            $("#pop").click(function(){
                document.getElementById("judul_form").innerHTML = "Bahan Baku Baru";
                document.getElementById("action").value = "add";
                document.getElementById("id_bahan").value = -1;
                document.getElementById("nama").value = "";
                document.getElementById("tersedia").value = "0";
                document.getElementById("batas_minimum").value = "0";
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
            document.getElementById("judul_form").innerHTML = "Edit Data Bahan Baku (ID : "+id+")";
            document.getElementById("action").value = "edit";
            document.getElementById("id_bahan").value = id;
            document.getElementById("nama").value = document.getElementById("nama"+id).innerHTML;
            document.getElementById("tersedia").value = document.getElementById("tersedia"+id).innerHTML;
            document.getElementById("batas_minimum").value = document.getElementById("batas_minimum"+id).innerHTML;
            document.getElementById("btnSubmit").value = "ubah";
            $("#overlay_form").fadeIn(1000);
            positionPopup();
        }
    </script>

     <?php
        if(!is_null($message))
          echo "<script type='text/javascript'>alert('".$message."')</script>";
     ?>
</body>
</html>