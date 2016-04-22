<?php
  $host_db = 'localhost';
  // MySQL username
  $username_db = 'root';
  // MySQL password
  $password_db = '';
  // Database name
  $name_db = 'si';

  $db = mysqli_connect($host_db, $username_db, $password_db, $name_db);

  if (!$db)
    die("Connection failed: " . mysqli_connect_error());
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

    if(!$res) 
      return "Penambahan penjualan baru gagal";
    $komposisi = getKomposisi($id_produk);
    $bahan = getAllBahan();
    foreach ($komposisi as $key => $value) {
      $jumlah = $bahan[$key]['tersedia'] - $value;
      $qry = "UPDATE bahan_baku SET tersedia=$jumlah WHERE id=$key";
      $res = mysqli_query($db, $qry);
    }
    return null;
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
    if(!$res) 
      return "Penghapusan penjualan gagal";
    $komposisi = getKomposisi($penjualan['id_produk']);
    $bahan = getAllBahan();
    foreach ($komposisi as $key => $value) {
      $jumlah = $bahan[$key]['tersedia'] + $value;
      $qry = "UPDATE bahan_baku SET tersedia=$jumlah WHERE id=$key";
      $res = mysqli_query($db, $qry);
    }
    return null;
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
    if(!$res)
      return "Pengeditan penjualan gagal";
    $komposisi = getKomposisi($penjualan['id_produk']);
    $bahan = getAllBahan();
    foreach ($komposisi as $key => $value) {
      $jumlah = $bahan[$key]['tersedia'] + $value;
      $qry = "UPDATE bahan_baku SET tersedia=$jumlah WHERE id=$key";
      $bahan[$key]['tersedia'] = $jumlah;
      $res = mysqli_query($db, $qry);
    }
    $komposisi = getKomposisi($id_produk);
    $bahan = getAllBahan();
    foreach ($komposisi as $key => $value) {
      $jumlah = $bahan[$key]['tersedia'] - $value;
      $qry = "UPDATE bahan_baku SET tersedia=$jumlah WHERE id=$key";
      $res = mysqli_query($db, $qry);
    }
    return null;
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
  ////////////////////////////////////// CRUD Bahan //////////////////////////////////////////
  function getAllBahan() {
    global $db;
    $qry = "SELECT * FROM bahan_baku ORDER BY id ASC";
    $res = mysqli_query($db, $qry);
    $ret = array();
    $bahan = $res->fetch_assoc();
    while($bahan) {
      $ret[$bahan['id']] = $bahan;
      $bahan = $res->fetch_assoc();  
    }
    return $ret;
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
  /////////////////////////////// PESANAN BAHAN ////////////////////////////
  function addPesananBahan($username, $tanggal, $porsi) {
    global $db;
    $status = 0;
    $pegawai = getPegawai($username);
    if(is_null($pegawai))
      return "Pegawai tidak ditemukan";
    $qry = "INSERT INTO pesanan_bahan(username, tanggal, status) VALUES ('$username', '$tanggal', $status)";
    if(mysqli_query($db, $qry))
      $id = mysqli_insert_id($db);
    else
      return "Gagal";

    $fail = false;
    foreach ($porsi as $item) {
      $itemid = $item['id_bahan'];
      $itemjumlah = $item['jumlah'];
      $qry = "INSERT INTO porsi_pesan(id_pesan, id_bahan, jumlah) VALUES ($id, $itemid, $itemjumlah)";
      $res = mysqli_query($db, $qry);
      if(!$res)
        $fail = true;
    }
    if($fail)
      return "Terdapat kegagalan menambahkan porsi pesanan";
    return null;
  }
  function getPesananBahan() {
    global $db;
    $qry = "SELECT * FROM pesanan_bahan WHERE status = 0";
    $res = mysqli_query($db, $qry);
    $pesanan = $res->fetch_assoc();
    return $pesanan;
  }
  function verifyPesanan($id) {
    global $db;
    $qry = "UPDATE pesanan_bahan SET status=1 WHERE id=$id";
    $res = mysqli_query($db, $qry);
    $porsi = getPorsiPesan($id);
    $bahan = getAllBahan();
    $jumlah = array();
    foreach ($bahan as $item) {
      $jumlah[$item['id']] = $item['tersedia'];
    }
    $fail = false;
    foreach($porsi as $item) {
      if($item["dipesan"] > 0) {
        $hasil = $jumlah[$item['id']] + $item['dipesan'];
        $id_bahan = $item['id'];
        $qry = "UPDATE bahan_baku SET tersedia=$hasil WHERE id=$id_bahan";
        $res = mysqli_query($db, $qry);
        if(!$res)
          $fail = true;
      }
    }
    if($fail)
      return "Terdapat kesalahan";
    return null;
  }
  function getPorsiPesan($id) {
    global $db;
    $qry = "SELECT * FROM porsi_pesan WHERE id_pesan = $id";
    $res = mysqli_query($db, $qry);
    $porsi = $res->fetch_assoc();
    $jumlah = array();
    while($porsi) {
      $jumlah[$porsi['id_bahan']] = $porsi['jumlah'];
      $porsi = $res->fetch_assoc();
    }
    $ret = array();
    $bahan = getAllBahan();
    $length_bahan = count($bahan);
    for($i = 0; $i<$length_bahan; $i++) {
      $item = $bahan[$i];
      if(array_key_exists($item['id'],$jumlah))
        $item['dipesan'] = $jumlah[$item['id']];
      else
        $item['dipesan'] = 0;
      array_push($ret, $item);
    }
    return $ret;
  }
  function calculatePorsiPesan() {
    $bahan = getAllBahan();
    $ret = array();
    foreach ($bahan as $key => $item) {
      if($item['tersedia'] >= $item['batas_minimum'])
        $item['dipesan'] = 0;
      else
        $item['dipesan'] = $item['batas_minimum'] - $item['tersedia'];
      $ret[$key] = $item;
    }
    return $ret;
  }
  function editPorsiPesan($id, $porsi) {
    global $db;
    foreach($porsi as $item) {
      $jumlah = $item['jumlah'];
      $id_bahan = $item['id_bahan'];
      $qry = "SELECT * FROM porsi_pesan WHERE id_bahan=$id_bahan AND id_pesan=$id";
      $res = mysqli_query($db, $qry);
      if(is_null($res->fetch_row())) {
        $qry = "INSERT INTO porsi_pesan(id_bahan, id_pesan, jumlah) VALUES ($id_bahan, $id, $jumlah)";
        $res = mysqli_query($db, $qry);
      }
      else {
        $qry = "UPDATE porsi_pesan SET jumlah=$jumlah WHERE id_bahan=$id_bahan AND id_pesan=$id";
        $res = mysqli_query($db, $qry);
      }
    }
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
    $res = mysqli_query($db, $qry);
    $ret = array();
    $now = $res->fetch_assoc();
    while(!is_null($now)) {
      $ret[$now['id']] = $now;
      $now = $res->fetch_assoc();  
    }
    return $ret;
  }
  function addProduk($nama, $jenis, $harga, $komposisi) {
    global $db;
    $qry = "INSERT INTO produk(nama, jenis, harga) VALUES ('$nama', '$jenis', $harga)";
    $res = mysqli_query($db, $qry);
    if(!$res)
      return "Penambahan produk gagal";
    $id = mysqli_insert_id($db);
    $fail = false;
    foreach ($komposisi as $key => $value) {
      if($value > 0) {
        $qry = "INSERT INTO komposisi(id_produk, id_bahan, jumlah) VALUES ($id, $key, $value)";
        $res = mysqli_query($db, $qry);
        if(!$res)
          $fail = true;
      }
    }
    if($fail)
      return "Pengisian komposisi bahan gagal";
    return null;
  } 
  function editProduk($id, $nama, $jenis, $harga, $komposisi) {
    global $db;
    $qry = "SELECT * FROM produk WHERE id=$id";
    $res = mysqli_query($db, $qry);
    if(is_null($res->fetch_row()))
      return "Produk tidak ditemukan";
    $qry = "UPDATE produk SET nama='$nama', jenis='$jenis', harga=$harga WHERE id=$id";
    $res = mysqli_query($db, $qry);
    if(!$res)
      return "Pengeditan produk gagal";
    $before = getKomposisi($id);
    $fail = false;
    foreach ($komposisi as $key => $value) {
      if($value > 0) {
        if(isset($before[$key]))
          $qry = "UPDATE komposisi SET jumlah=$value WHERE id_produk=$id AND id_bahan=$key";
        else
          $qry = "INSERT INTO komposisi(id_produk, id_bahan, jumlah) VALUES ($id, $key, $value)";
        $res = mysqli_query($db, $qry);
        if(!$res)
          $fail = true;
      }
      elseif (isset($before[$key])) {
        $qry = "DELETE FROM komposisi WHERE id_produk=$id AND id_bahan=$key";
        $res = mysqli_query($db, $qry);
        if(!$res)
          $fail = true;
      }
    }
    if($fail)
      return "Pengisian komposisi bahan gagal";
    return null;

  }
  function deleteProduk($id) {
    global $db;
    $qry = "DELETE FROM komposisi WHERE id_produk=$id";
    $res = mysqli_query($db, $qry);
    if(!$res)
      return "Penghapusan komposisi gagal";
    $qry = "DELETE FROM produk WHERE id=$id";
    $res = mysqli_query($db, $qry);
    if(!$res)
      return "Penghapusan komposisi gagal";
    return null;
  }
  function getKomposisi($id_produk) {
    global $db;
    $qry = "SELECT * FROM komposisi WHERE id_produk=$id_produk";
    $res = mysqli_query($db, $qry);
    $now = $res->fetch_assoc();
    $ret = array();
    while(!is_null($now)) {
      $ret[$now['id_bahan']] = $now['jumlah'];
      $now = $res->fetch_assoc();
    }
    return $ret;
  }
  function addKomposisi($id_produk, $id_bahan, $jumlah) {
    global $db;
    $qry = "SELECT * FROM produk WHERE id=$id_produk";
    $res = mysqli_query($db, $qry);
    if(is_null($res->fetch_assoc()))
      return "Produk tidak tersedia";
    $qry = "INSERT INTO komposisi(id_produk, id_bahan, jumlah) VALUES ($id_produk, $id_bahan, $jumlah)";
    $res = mysqli_query($db, $qry);
    if(!$res)
      return "Penambahan komposisi gagal";
    return null;
  }
  function editKomposisi($id_produk, $id_bahan, $jumlah) {
    global $db;
    $qry = "UPDATE komposisi SET jumlah=$jumlah WHERE id_produk=$id_produk AND id_bahan=$id_bahan";
    $res = mysqli_query($db, $qry);
    if(!$res)
      return "Pengeditan komposisi gagal";
    return null; 
  }
  function deleteKomposisi($id_produk, $id_bahan) {
    global $db;
    $qry = "DELETE FROM komposisi WHERE id_produk=$id_produk AND id_bahan=$id_bahan";
    $res = mysqli_query($db, $qry);
    if(!$res)
      return "Penghapusan komposisi gagal";
    return null;
  }
  ////////////////////////////////// Statistik //////////////////////////////////
  function getJenisProduk() {
    global $db;
    $qry = "SELECT DISTINCT jenis FROM produk";
    $res = mysqli_query($db, $qry);
    $ret = array();
    $jenis = $res->fetch_assoc();
    while(!is_null($jenis)) {
      array_push($ret, $jenis['jenis']);
      $jenis = $res->fetch_assoc();  
    }
    return $ret;
  }
  function getStat($kategori, $awal, $akhir) {
    global $db;
    if($kategori == "semua")
      $qry = "SELECT tanggal, count(*) as banyak FROM penjualan GROUP BY tanggal HAVING tanggal >= '$awal' AND tanggal <= '$akhir'";
    else
      $qry = "SELECT tanggal, count(*) as banyak FROM penjualan INNER JOIN (SELECT * FROM produk WHERE jenis='$kategori') AS prod ON penjualan.id_produk=prod.id GROUP BY tanggal HAVING tanggal >= '$awal' AND tanggal<='$akhir'";
    $res = mysqli_query($db, $qry);
    $stat = array();
    $now = $res->fetch_assoc();
    while(!is_null($now)) {
      array_push($stat, $now);
      $now = $res->fetch_assoc();
    }
    $ret = array();
    foreach ($stat as $item) {
      $date = strtotime($item['tanggal']);
      $ret[Date("F Y", $date)] = 0;
    }
    foreach ($stat as $item) {
      $date = strtotime($item['tanggal']);
      $ret[Date("F Y", $date)] += $item['banyak'];
    }
    return $ret;
  }
?>