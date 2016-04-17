<?php
  $host_db = 'localhost';
  // MySQL username
  $username_db = 'root';
  // MySQL password
  $password_db = '';
  // Database name
  $name_db = 'si';

  $db = mysqli_connect($host_db, $username_db, $password_db, $name_db);

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
  function deletePenjualan($id) {
    global $db;
    $qry = "SELECT * FROM penjualan WHERE id='$id'";
    $res = mysqli_query($db, $qry);
    if(is_null($res->fetch_row()))
      return "Penjualan yang akan dihapus tidak tersedia";
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
    if(is_null($res->fetch_row()))
      return "Penjualan yang akan diedit tidak tersedia";
    $qry = "UPDATE penjualan SET username='$username', id_produk='$id_produk', tanggal='$tanggal', harga_terjual='$harga' WHERE id='$id'";
    $res = mysqli_query($db, $qry);
    if($res) 
      return null;
    else
      return "Pengeditan penjualan gagal";
  }
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
  function addAlat($ID, $Nama, $Status, $Kondisi, $Waktu){
    global $db;
    $qry = "SELECT * FROM alat WHERE ID=$ID";
    $res = mysqli_query($db, $qry);

    if(!is_null($res->fetch_row()))
      return "ID Alat sudah ada";
    $qry = "INSERT INTO alat (ID, Nama, Status, Kondisi, Waktu_Selesai) VALUES ('$ID', '$Nama', '$Status', '$Kondisi', '$Waktu')";
    $res = mysqli_query($db, $qry);
    if($res)
      return null;
    else
      return "Alat baru gagal ditambahkan";
  }

  function addBooking($ID_User, $ID_Alat, $Waktu_Mulai, $Waktu_Pengembalian){
    global $db;

    $qry = "SELECT * FROM user WHERE ID=$ID_User";
    $res = mysqli_query($db, $qry);
    if(is_null($res->fetch_row()))
      return "ID User tidak ditemukan";

    // Cek alat
    $qry = "SELECT * FROM alat WHERE ID=$ID_Alat";
    $res = mysqli_query($db, $qry);
    $alat = $res->fetch_assoc();
    if(is_null($alat))
      return "ID Alat tidak ditemukan";
    if($alat["Kondisi"] != "Baik")
      return "Alat dalam keadaan tidak baik";

    // Cek booking
    $qry = "SELECT * FROM booking WHERE ID_Alat=$ID_Alat ORDER BY Waktu_Mulai";
    $res = mysqli_query($db, $qry);
    $booking = $res->fetch_assoc();
    while(!is_null($booking)) {
      if((strtotime($booking['Waktu_Mulai']) < strtotime($Waktu_Pengembalian)) and (strtotime($Waktu_Mulai) < strtotime($booking['Waktu_Pengembalian'])))
        return "Alat telah dibooking dari ".$booking['Waktu_Mulai']." sampai ".$booking['Waktu_Pengembalian']." oleh user dengan ID ".$booking['ID_User']; 
      $booking = $res->fetch_assoc();
    }

    // Cek Transaksi
    $qry = "SELECT * FROM transaksi WHERE ID_Alat=$ID_Alat ORDER BY Waktu_Pengembalian";
    $res = mysqli_query($db, $qry);
    $transaksi = $res->fetch_assoc();
    while(!is_null($transaksi)) {
      if(strtotime($transaksi['Waktu_Pengembalian']) > strtotime($Waktu_Mulai)) {
        return "Alat baru dikembalikan pada ".$transaksi['Waktu_Pengembalian']." oleh user dengan ID ".$transaksi['ID_User'];
      }
      $transaksi = $res->fetch_assoc();
    }    

    $qry = "INSERT INTO booking (ID, ID_User, ID_Alat, Waktu_Mulai, Waktu_Pengembalian) VALUES (NULL, '$ID_User', '$ID_Alat', '$Waktu_Mulai', '$Waktu_Pengembalian')";
    $res = mysqli_query($db, $qry);
    if($res)
      return null;
    else
      return "Booking gagal ditambahkan";    
  }

  function addTransaksi($ID_User, $ID_Alat, $Waktu_Pengembalian){
    global $db;

    $qry = "SELECT * FROM user WHERE ID=$ID_User";
    $res = mysqli_query($db, $qry);
    if(is_null($res->fetch_row()))
      return "ID User tidak ditemukan";

    $qry = "SELECT * FROM alat WHERE ID=$ID_Alat";
    $res = mysqli_query($db, $qry);
    $alat = $res->fetch_assoc();
    if(is_null($alat))
      return "ID Alat tidak ditemukan";
    if($alat["Kondisi"] != "Baik")
      return "Alat dalam keadaan tidak baik";
    if(cekAlat($ID_Alat))
      return "Alat sedang dipakai";

    $qry = "SELECT * FROM booking WHERE ID_Alat=$ID_Alat ORDER BY Waktu_Mulai";
    $res = mysqli_query($db, $qry);
    $booking = $res->fetch_assoc();
    while(!is_null($booking)) {
      if((strtotime($booking['Waktu_Mulai']) < strtotime($Waktu_Pengembalian)) and (strtotime(Date("Y-m-d")) < strtotime($booking['Waktu_Pengembalian'])))
        return "Alat telah dibooking dari ".$booking['Waktu_Mulai']." sampai ".$booking['Waktu_Pengembalian']." oleh user dengan ID ".$booking['ID_User']; 
      $booking = $res->fetch_assoc();
    }

    $qry = "INSERT INTO transaksi (ID, Waktu_Pengembalian, ID_User, ID_Alat) VALUES (NULL, '$Waktu_Pengembalian', '$ID_User', '$ID_Alat')";
    $res = mysqli_query($db, $qry);
    if($res) {
      $qry = "UPDATE alat SET Status='Dipinjam' WHERE ID='$ID_Alat'";
      $res = mysqli_query($db, $qry);
      if($res)
        return null;
      else
        return "Transaksi gagal ditambahkan";
    }
    else
      return "Transaksi gagal ditambahkan";
  }

  function cekAlat($ID) {
    global $db;

    $qry = "SELECT * FROM alat WHERE ID=$ID";
    $res = mysqli_query($db, $qry);
    $alat = $res->fetch_assoc();
    if(is_null($alat))
      return false;
    $status = "Tersedia";

    // Cek Transaksi
    $qry = "SELECT * FROM transaksi WHERE ID_Alat=$ID ORDER BY Waktu_Pengembalian";
    $res = mysqli_query($db, $qry);
    $transaksi = $res->fetch_assoc();
    while(!is_null($transaksi)) {
      if(strtotime($transaksi['Waktu_Pengembalian']) > strtotime(Date("Y-m-d"))) {
        $status = "Dipinjam";
        break;
      } 
      $transaksi = $res->fetch_assoc();
    }

    if($status == "Tersedia") {
      // Cek Booking
      $qry = "SELECT * FROM booking WHERE ID_Alat=$ID ORDER BY Waktu_Mulai";
      $res = mysqli_query($db, $qry);
      $booking = $res->fetch_assoc();
      while(!is_null($booking)) {
        if((strtotime($booking['Waktu_Mulai']) < strtotime(Date("Y-m-d"))) and (strtotime(Date("Y-m-d")) < strtotime($booking['Waktu_Pengembalian']))) {
          $status = "Dipinjam";
          break;
        } 
        $booking = $res->fetch_assoc();
      }
    }
    if($status != $alat['Status']) {
      $qry = "UPDATE alat SET Status='$status' WHERE ID='$ID'";
      $res = mysqli_query($db, $qry);
    }
    return $status != 'Tersedia';
  }

  function updateStatusAlat($ID, $Status){
    global $db;

    $qry = "SELECT * FROM alat WHERE ID=$IDt";
    $res = mysqli_query($db, $qry);
    if(is_null($res->fetch_row()))
      return "ID Alat tidak ditemukan";

    $qry = "UPDATE alat SET Status='$Status' WHERE ID='$ID'";
    $res = mysqli_query($db, $qry);
    
    if($res)
      return "Status alat berhasil diubah";
    else
      return "Status alat gagal diubah";
  }

  function updateKondisiAlat($ID, $Kondisi) {
    global $db;

    $qry = "SELECT * FROM alat WHERE ID=$ID";
    $res = mysqli_query($db, $qry);
    $alat = $res->fetch_assoc();
    if(is_null($alat))
      return "ID Alat tidak ditemukan";
    if($alat["Kondisi"] == "Baik" and $Kondisi != "Rusak") {
      return 'Kondisi alat adalah "Baik". Dan hanya bisa diubah menjadi "Rusak"';
    }
    if($alat["Kondisi"] == "Rusak" and $Kondisi != "Diperbaiki") {
      return 'Kondisi alat adalah "Rusak". Dan hanya bisa diubah menjadi "Diperbaiki"';
    }
    if($alat["Kondisi"] == "Diperbaiki" and $Kondisi != "Baik") {
      return 'Kondisi alat adalah "Diperbaiki". Dan hanya bisa diubah menjadi "Baik"';
    }
    $qry = "UPDATE alat SET Kondisi='$Kondisi' WHERE ID='$ID'";
    $res = mysqli_query($db, $qry);
    
    if($res)
      return null;
    else
      return "Kondisi alat gagal diubah";
  }
  function getUser() {
    global $db;

    $qry = "SELECT * FROM user";
    $res = mysqli_query($db, $qry);
    return $res;
  }

  function getAlat() {
    global $db;

    $qry = "SELECT * FROM alat";
    $res = mysqli_query($db, $qry);
    return $res;
  }

  function frekPenggunaan() {
    global $db;

    $qry = "SELECT * FROM transaksi";
    $trans = mysqli_query($db, $qry);
    $ret = array();
    foreach($trans as $tran)
      $ret[date("M Y", strtotime($tran["Waktu_Pengembalian"]))] = 0;
    foreach($trans as $tran)
      $ret[date("M Y", strtotime($tran["Waktu_Pengembalian"]))]++;
    return $ret;
  }

  function frekPemesanan() {
    global $db;

    $qry = "SELECT * FROM booking";
    $trans = mysqli_query($db, $qry);
    $ret = array();
    foreach($trans as $tran)
      $ret[date("M Y", strtotime($tran["Waktu_Mulai"]))] = 0;
    foreach($trans as $tran)
      $ret[date("M Y", strtotime($tran["Waktu_Mulai"]))]++;
    return $ret;
  }
?>