<?php
  $host_db = 'localhost';
  // MySQL username
  $username_db = 'root';
  // MySQL password
  $password_db = '';
  // Database name
  $name_db = 'si';

  $db = mysqli_connect($host_db, $username_db, $password_db, $name_db);
  ////////////////////////////////////////////// CRUD Penjualan //////////////////////////
  function getAllPenjualan() {
    global $db;
    $qry = "SELECT * FROM penjualan ORDER BY tanggal DESC";
    $res = mysqli_query($db, $qry);
    $jual = $res->fetch_assoc();
    $penjualan = array();
    while(!is_null($jual)) {
      $produk = getProduk($jual["id_produk"]);
      $jual["nama_produk"] = $produk["nama"];
      array_push($penjualan, $jual);
      $jual = $res->fetch_assoc();
    }
    return $penjualan;
  }
  function addPenjualan($username, $id_produk, $tanggal, $harga){
    global $db;
    $qry = "SELECT * FROM produk WHERE id='$id_produk'";
    $res = mysqli_query($db, $qry);
    if(is_null($res->fetch_row()))
      return "Produk tidak tersedia";

    $qry = "INSERT INTO penjualan(username, id_produk, tanggal, harga_terjual) VALUES ('$username', '$id_produk', '$tanggal', '$harga')";
    $res = mysqli_query($db, $qry);
    if($res) 
      return null;
    else
      return "Penambahan penjualan baru gagal";
  }
  function deletePenjualan($id, $username) {
    global $db;
    $qry = "SELECT * FROM penjualan WHERE id='$id'";
    $res = mysqli_query($db, $qry);
    $penjualan = $res->fetch_assoc();
    if(is_null($penjualan))
      return "Penjualan yang akan dihapus tidak tersedia";
    if($penjualan["username"] != $username)
      return "Pengguna ".$username." tidak berhak menghapus penjualan dengan ID ".$id;
    $qry = "DELETE FROM penjualan WHERE id='$id'";    
    $res = mysqli_query($db, $qry);
    if($res) 
      return null;
    else
      return "Penghapusan penjualan gagal";
  }
  function editPenjualan($id, $username, $id_produk, $tanggal, $harga){
    global $db;
    $qry = "SELECT * FROM produk WHERE id='$id_produk'";
    $res = mysqli_query($db, $qry);
    if(is_null($res->fetch_row()))
      return "Produk tidak tersedia";

    $qry = "SELECT * FROM penjualan WHERE id='$id'";
    $res = mysqli_query($db, $qry);
    $penjualan = $res->fetch_assoc();
    if(is_null($penjualan))
      return "Penjualan yang akan diedit tidak tersedia";
    if($penjualan["username"] != $username)
      return "Pengguna ".$username." tidak berhak mengubah penjualan dengan ID ".$id;
    $qry = "UPDATE penjualan SET username='$username', id_produk='$id_produk', tanggal='$tanggal', harga_terjual='$harga' WHERE id='$id'";
    $res = mysqli_query($db, $qry);
    if($res) 
      return null;
    else
      return "Pengeditan penjualan gagal";
  }
  /////////////////////////////////////// Pegawai //////////////////////////////////////////
  function getPegawai($username) {
    global $db;
    $qry = "SELECT * FROM pegawai_operasional WHERE username='$username'";
    $res = mysqli_query($db, $qry);
    $pegawai = $res->fetch_assoc();
    if(!is_null($pegawai)) {
      $pegawai["jenis"] = "operasional";
      return $pegawai;
    }
    $qry = "SELECT * FROM pegawai_pengadaan WHERE username='$username'";
    $res = mysqli_query($db, $qry);
    $pegawai = $res->fetch_assoc();
    if(!is_null($pegawai)) {
      $pegawai["jenis"] = "pengadaan";
      return $pegawai;
    }
    return null;
  }
  /////////////////////////////////////// Produk /////////////////////////////////////////////
  function getProduk($id) {
    global $db;
    $qry = "SELECT * FROM produk WHERE id=$id";
    $res = mysqli_query($db, $qry);
    return $res->fetch_assoc();
  }
  function getAllProduk() {
    global $db;
    $qry = "SELECT * FROM produk";
    return mysqli_query($db, $qry);
  }
  ////////////////////////////////////// CRUD Bahan //////////////////////////////////////////
  function getAllBahan() {
    global $db;
    $qry = "SELECT * FROM bahan_baku ORDER BY id ASC";
    $res = mysqli_query($db, $qry);
    return $res;
  }
  function addBahan($nama, $tersedia, $batas_minimum){
    global $db;
    $qry = "INSERT INTO bahan_baku(nama, tersedia, batas_minimum) VALUES ('$nama', $tersedia, $batas_minimum)";
    $res = mysqli_query($db, $qry);
    if($res) 
      return null;
    else
      return "Penambahan bahan baku baru gagal";
  }
  function deleteBahan($id) {
    global $db;
    $qry = "SELECT * FROM bahan_baku WHERE id='$id'";
    $res = mysqli_query($db, $qry);
    $bahan = $res->fetch_assoc();
    if(is_null($bahan))
      return "Bahan baku yang akan dihapus tidak tersedia";
    $qry = "DELETE FROM bahan_baku WHERE id='$id'";   
    $res = mysqli_query($db, $qry);
    if($res) 
      return null;
    else
      return "Penghapusan bahan baku gagal";
  }
  function editBahan($id, $nama, $tersedia, $batas_minimum){
    global $db;
    $qry = "SELECT * FROM bahan_baku WHERE id='$id'";
    $res = mysqli_query($db, $qry);
    $bahan = $res->fetch_assoc();
    if(is_null($bahan))
      return "Bahan baku yang akan diedit tidak tersedia";
    $qry = "UPDATE bahan_baku SET nama='$nama', tersedia=$tersedia, batas_minimum=$batas_minimum WHERE id='$id'";
    $res = mysqli_query($db, $qry);
    if($res) 
      return null;
    else
      return "Pengeditan bahan baku gagal";
  }
?>