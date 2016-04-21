<?php
    session_start();
    
    include "Conf.php";
    include("DBConnector.php");
    function authOperasional() {
      if(!isset($_SESSION["username"])) {
        header("Location: index.php");
        exit;
      }
      $pegawai = getPegawai($_SESSION["username"]);
      if(is_null($pegawai) || $pegawai["jenis"] != "operasional") {
        header("Location: index.php");
        exit;
      }
    }
    function authPengadaan() {
      if(!isset($_SESSION["username"])) {
        header("Location: index.php");
        exit;
      }
      $pegawai = getPegawai($_SESSION["username"]);
      if(is_null($pegawai) || $pegawai["jenis"] != "pengadaan") {
        header("Location: index.php");
        exit;
      }
    }
    function authPegawai() {
      if(!isset($_SESSION["username"])) {
        header("Location: index.php");
        exit;
      }
      $pegawai = getPegawai($_SESSION["username"]);
      if(is_null($pegawai)) {
        header("Location: index.php");
        exit;
      }
      return $pegawai["jenis"];
    }
  ?>