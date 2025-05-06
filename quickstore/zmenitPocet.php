<?php


include('server.php');
session_start();
header('Content-Type: application/json');
$db = mysqli_connect('127.0.0.1:3308', 'root', "", 'mydb'); 
//$db = mysqli_connect("db.mp.spse-net.cz","svatosad","pysuchesifuma","svatosad_1");
if ($db->connect_error) {
  die("chyba při připojování k databázi" . $db->connect_error);
}

if ($_GET['pocet'] < 1) return;

  $pocet = $_GET['pocet'];
  $idKosik = $_GET['idKosik'];
  
  $query = "UPDATE kosik SET pocet=? WHERE idKosik=?";
  $stmt = $db->prepare($query);
  $stmt->bind_param("ss", $pocet, $idKosik);
  $stmt->execute();
  
  $kosik_pole = kosik($db);
  $celkem = 0;
  
  for ($i = 0; $i < count($kosik_pole); $i++) {
  $celkem += ((int) $kosik_pole[$i]["cenaProdukt"]) * ((int) $kosik_pole[$i]["pocet"]);
  }
  
  echo json_encode(number_format((int)$celkem, 2, '.', ' '));

