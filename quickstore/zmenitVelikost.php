<?php
 //$db = mysqli_connect("db.mp.spse-net.cz","svatosad","pysuchesifuma","svatosad_1");
$db = mysqli_connect('127.0.0.1:3308', 'root', "", 'mydb');
if ($db->connect_error) {
  die("chyba při připojování k databázi" . $db->connect_error);
}

$velikost = $_GET['velikost'];
$idKosik = $_GET['idKosik'];

$query = "UPDATE kosik SET velikost=? WHERE idKosik=?";
$stmt = $db->prepare($query);
$stmt->bind_param("ss", $velikost, $idKosik);
$stmt->execute();