<?php

$errors = array();
//$db = mysqli_connect("db.mp.spse-net.cz", "svatosad", "pysuchesifuma", "svatosad_1");
$db = mysqli_connect('127.0.0.1:3308', 'root', "", 'mydb');
if ($db->connect_error) {
  die("chyba při připojování k databázi" . $db->connect_error);
}

if (isset($_SESSION['idUzivatel'])) {
  $user_check_query = "SELECT * FROM uzivatel WHERE idUzivatel=? LIMIT 1";
  $stmt = $db->prepare($user_check_query);
  $stmt->bind_param("s", $_SESSION['idUzivatel']);
  $stmt->execute();
  $uzivatel = $stmt->get_result()->fetch_assoc();
  $jmeno = $uzivatel['jmeno'];
  $prijmeni = $uzivatel['prijmeni'];
  $email = $uzivatel['email'];
}

function getProduktSloupceLookup(): array
{
  $produkt_sloupce = ["kategorieProdukt", "znackaProdukt", "barvaProdukt", "pohlaviProdukt"];
  $produkt_lookup = [];
  foreach ($produkt_sloupce as $sloupec) {
    $produkt_lookup[$sloupec] = true;
  }
  return $produkt_lookup;
}

function destroyVyberObleceni()
{
  if (isset($_GET["delete_vyber_submit"])) {
    unset($_GET);
  }
}

destroyVyberObleceni();



function poleProdukt($db): array
{
  $produktSelect = "SELECT * FROM produkt";
  $produkt_lookup = getProduktSloupceLookup();
  $arr_vyber = $_GET;
  unset($arr_vyber['vyber_submit']);
  $where = "";
  $parametry = [];
  $firstParam = true;
  foreach ($arr_vyber as $parametr => $hodnoty) {
    if (isset($produkt_lookup[$parametr])) {
      $where .= (!$firstParam ? " AND " : "") . "(";
      $firstParam = false;
      $firstValue = true;
      foreach ($hodnoty as $hodnota) {
        $where .= (!$firstValue ? " OR " : "") . "$parametr = ?";
        $firstValue = false;
        $parametry[] = $hodnota;
      }
      $where .= ")";
    }
  }

  if (isset($_GET["cenaProduktMin"]) && isset($_GET["cenaProduktMax"])) {
    $where .= (!empty($parametry) ? " AND " : "") . "cenaProdukt >= ? AND cenaProdukt <= ?";
    $parametry[] = $_GET["cenaProduktMin"];
    $parametry[] = $_GET["cenaProduktMax"];
  }

  if (isset($_GET["hledat"])) {
    $where .= (!empty($parametry) ? " AND " : "")
      . "(jmenoProdukt LIKE ? 
    OR kategorieProdukt LIKE ? 
    OR barvaProdukt LIKE ? 
    OR znackaProdukt LIKE ? 
    OR pohlaviProdukt LIKE ?)";
    for ($i = 0; $i < 5; $i++) {
      $parametry[] = "%" . $_GET["hledat"] . "%";
    }
  }

  if (!empty($parametry)) {
    $produktSelect .= " WHERE " . $where;
  }

  // return $produktSelect;

  $stmt = $db->prepare($produktSelect);
  if (!empty($parametry)) {
    $stmt->bind_param(str_repeat("s", count($parametry)), ...$parametry);
  }
  $stmt->execute();
  $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
  return $result;
}







function doporucujemeProdukt(): array
{
  //$db = mysqli_connect("db.mp.spse-net.cz", "svatosad", "pysuchesifuma", "svatosad_1");
  $db = mysqli_connect('127.0.0.1:3308', 'root', "", 'mydb');
  mysqli_set_charset($db, "utf8_czech_ci");
  if ($db->connect_error) {
    die("chyba při připojování k databázi" . $db->connect_error);
  }
  $produktSelect = "SELECT * FROM produkt WHERE idProdukt=4 OR idProdukt=8 OR idProdukt=1 OR idProdukt=11 OR idProdukt=14 OR idProdukt=16 OR idProdukt=20 OR idProdukt=19";
  $stmt = $db->prepare($produktSelect);
  $stmt->execute();
  $produkt_pole = [];
  $produkt = $stmt->get_result();
  while ($row = $produkt->fetch_assoc()) {
    array_push($produkt_pole, $row);
  }

  return $produkt_pole;
}




if (isset($_POST['register'])) {
  $jmeno = $_POST['jmeno'];
  $prijmeni = $_POST['prijmeni'];
  $email = $_POST['email'];
  $heslo_1 = $_POST['heslo_1'];
  $heslo_2 = $_POST['heslo_2'];

  if ($heslo_1 != $heslo_2) {
    array_push($errors, "Hesla se neshodují");
    return;
  }

  $user_check_query = "SELECT * FROM uzivatel WHERE email=?";
  $stmt = $db->prepare($user_check_query);
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $uzivatel = $stmt->get_result()->fetch_assoc();

  if ($uzivatel) {
    array_push($errors, "Email již existuje");
    return;
  }

  $heslo = password_hash($heslo_2, PASSWORD_DEFAULT);

  $query = "INSERT INTO uzivatel (jmeno, prijmeni, email, heslo) 
                  VALUES(?, ?, ?, ?)";
  $stmt = $db->prepare($query);
  $stmt->bind_param("ssss", $jmeno, $prijmeni, $email, $heslo);
  $stmt->execute();
  $user_check_query = "SELECT idUzivatel FROM uzivatel WHERE email=? LIMIT 1";
  $stmt = $db->prepare($user_check_query);
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $uzivatel = $stmt->get_result()->fetch_assoc();
  $_SESSION['idUzivatel'] = $uzivatel["idUzivatel"];
  $_SESSION['prihlasen'] = "Jste úspěšně zaregistrován";
  header('location: index.php');
}

if (isset($_POST['login'])) {
  $email = $_POST['email'];
  $heslo = $_POST['heslo'];

  if (count($errors) == 0) {
    $query = "SELECT * FROM uzivatel WHERE email=?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();


    if ($result == null || !password_verify($heslo, $result["heslo"])) {
      array_push($errors, "Špatný email nebo heslo");
      return;
    }
    $_SESSION['idUzivatel'] = $result["idUzivatel"];
    $_SESSION['prihlasen'] = "Jste úspěšně přihlášen";
    header('location: index.php');
  }
}

if (isset($_POST['zmenaudaju'])) {
  $jmeno_ = $_POST['jmeno'];
  $prijmeni_ = $_POST['prijmeni'];
  $email_ = $_POST['email'];

  $query = "SELECT * FROM uzivatel WHERE email=?";
  $stmt = $db->prepare($query);
  $stmt->bind_param("s", $email_);
  $stmt->execute();
  $result = $stmt->get_result()->fetch_assoc();

  if ($result && $_SESSION['idUzivatel'] != $result["idUzivatel"]) {
    array_push($errors, "Email již existuje");
    return;
  }


  $query = "UPDATE uzivatel SET jmeno=?, prijmeni=?, email=? WHERE idUzivatel=?";
  $stmt = $db->prepare($query);
  $stmt->bind_param("ssss", $jmeno_, $prijmeni_, $email_, $_SESSION["idUzivatel"]);
  $stmt->execute();

  $jmeno = $jmeno_;
  $prijmeni = $prijmeni_;
  $email = $email_;

  $success = true;
}


if (isset($_POST['zmenahesla'])) {
  $heslo = $_POST['heslo'];
  $heslo_1 = $_POST['heslo_1'];
  $heslo_2 = $_POST['heslo_2'];

  if ($heslo_1 != $heslo_2) {
    array_push($errors, "Hesla se neshodují");
    return;
  }

  $query = "SELECT * FROM uzivatel WHERE idUzivatel=?";
  $stmt = $db->prepare($query);
  $stmt->bind_param("s", $_SESSION['idUzivatel']);
  $stmt->execute();
  $result = $stmt->get_result()->fetch_assoc();

  if (!password_verify($heslo, $result["heslo"])) {
    array_push($errors, "Špatné heslo");
    return;
  }

  if (password_verify($heslo_2, $result["heslo"])) {
    array_push($errors, "Nové heslo se shoduje se starým");
    return;
  }



  $heslo = password_hash($heslo_2, PASSWORD_DEFAULT);

  $query = "UPDATE uzivatel SET heslo=? WHERE idUzivatel=?";
  $stmt = $db->prepare($query);
  $stmt->bind_param("ss", $heslo, $_SESSION["idUzivatel"]);
  $stmt->execute();

  $success = true;
}


if (isset($_POST['zmenaudaju-id'])) {
  include_once('kontrola_admin.php');

  $idUzivatel_ = $_GET["id"];
  $jmeno_ = $_POST['jmeno'];
  $prijmeni_ = $_POST['prijmeni'];
  $email_ = $_POST['email'];

  // test existujiciho id uzivatele
  $query = "SELECT email FROM uzivatel WHERE idUzivatel=?";
  $stmt = $db->prepare($query);
  $stmt->bind_param("s", $idUzivatel_);
  $stmt->execute();
  $result = $stmt->get_result()->fetch_assoc();

  if (!$result) {
    header("location: index.php");
    return;
  }

  $old_email = $result["email"];

  // test existujiciho emailu
  $query = "SELECT * FROM uzivatel WHERE email=?";
  $stmt = $db->prepare($query);
  $stmt->bind_param("s", $email_);
  $stmt->execute();
  $result = $stmt->get_result()->fetch_assoc();
  if ($result['email']  && $_POST['email'] != $old_email) {
    array_push($errors, "Email již existuje");
    return;
  }

  $query = "UPDATE uzivatel SET jmeno=?, prijmeni=?, email=? WHERE idUzivatel=?";
  $stmt = $db->prepare($query);
  $stmt->bind_param("ssss", $jmeno_, $prijmeni_, $email_, $idUzivatel_);
  $stmt->execute();
  $success = true;
}

if (isset($_POST['smazani-id'])) {
  $mazani = $_GET["id"];
  $smazani = $db->prepare("DELETE FROM uzivatel WHERE idUzivatel = $mazani");
  $smazani->execute();
  header("location: rizeni.php");
  exit();
}


if (isset($_POST['smazani-produkt'])) {
  $mazani = $_GET["id"];
  $smazani = $db->prepare("DELETE FROM produkt WHERE idProdukt = $mazani");
  $smazani->execute();
  header("location: produkty_uprava.php");
  exit();
}


if (isset($_POST['zmenaudaju-produkt'])) {
  include_once('kontrola_admin.php');
  require_once("nahrani.php");

  $idProdukt = $_GET["id"];
  $jmenoProdukt = $_POST['jmenoProdukt'];
  $popisProdukt = $_POST['popisProdukt'];
  $cenaProdukt = $_POST['cenaProdukt'];
  if (is_uploaded_file($_FILES['fotka']['tmp_name'])) {
    unlink($_POST["imageProdukt"]);
    $uploadVysledek = nahrani($jmenoProdukt);
    if (isset($uploadVysledek["file"])) {
      $imageProdukt = $uploadVysledek["file"];
    } else {
      $fileUploadMessage = $uploadVysledek["message"];
    }
  } else {
    $imageProdukt = $_POST["imageProdukt"];
  }
  $kategorieProdukt = $_POST['kategorieProdukt'];
  $znackaProdukt = $_POST['znackaProdukt'];
  $barvaProdukt = $_POST['barvaProdukt'];
  $pohlaviProdukt = $_POST['pohlaviProdukt'];

  if (isset($imageProdukt)) {
    $query = "SELECT * FROM produkt WHERE idProdukt=?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("s", $idProdukt);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    if (!$result) {
      header("location: index.php");
      return;
    }


    $query = "UPDATE produkt SET jmenoProdukt=?, popisProdukt=?, cenaProdukt=?, imageProdukt=?, kategorieProdukt=?, znackaProdukt=?, barvaProdukt=?, pohlaviProdukt=?  WHERE idProdukt=?";
    $stmt = $db->prepare($query);
    $stmt->bind_param("sssssssss", $jmenoProdukt, $popisProdukt, $cenaProdukt, $imageProdukt, $kategorieProdukt, $znackaProdukt, $barvaProdukt, $pohlaviProdukt, $idProdukt);
    $stmt->execute();
    $success = true;
  }
}


if (isset($_POST['pridani-produkt'])) {
  include_once('kontrola_admin.php');
  require_once("nahrani.php");

  $jmenoProdukt = $_POST['jmenoProdukt'];
  $popisProdukt = $_POST['popisProdukt'];
  $cenaProdukt = $_POST['cenaProdukt'];
  $uploadVysledek = nahrani($jmenoProdukt);
  if (isset($uploadVysledek["message"])) {
    $fileUploadMessage = $uploadVysledek["message"];
  } else {
    $imageProdukt = $uploadVysledek["file"];
    $kategorieProdukt = $_POST['kategorieProdukt'];
    $znackaProdukt = $_POST['znackaProdukt'];
    $barvaProdukt = $_POST['barvaProdukt'];
    $pohlaviProdukt = $_POST['pohlaviProdukt'];




    $query = "INSERT INTO produkt ( jmenoProdukt, popisProdukt, cenaProdukt, imageProdukt, kategorieProdukt, znackaProdukt, barvaProdukt, pohlaviProdukt) VALUES
  ( ?,?,?,?,?,?,?,?)";
    $pridani = $db->prepare($query);
    $pridani->bind_param("ssssssss", $jmenoProdukt, $popisProdukt, $cenaProdukt, $imageProdukt, $kategorieProdukt, $znackaProdukt, $barvaProdukt, $pohlaviProdukt);
    $pridani->execute();
    header("location: produkty_uprava.php");
  }
}

function kosik($db): array
{
  $iduzivatel = $_SESSION['idUzivatel'];
  $kosikselect = "SELECT produkt.idProdukt, produkt.jmenoProdukt, produkt.cenaProdukt, produkt.imageProdukt,
   produkt.kategorieProdukt, produkt.znackaProdukt, produkt.barvaProdukt, produkt.pohlaviProdukt, kosik.velikost, kosik.pocet, kosik.idKosik
    FROM produkt JOIN kosik ON kosik.produkt_idprodukt = produkt.idProdukt WHERE kosik.uzivatel_iduzivatel = $iduzivatel";

  $stmt = $db->prepare($kosikselect);
  $stmt->execute();
  $kosik_pole = [];
  $produkt = $stmt->get_result();
  while ($row = $produkt->fetch_assoc()) {
    array_push($kosik_pole, $row);
  }

  return $kosik_pole;
}

  if (!empty($_POST["mesto"]) && !empty($_POST["adres_cp"]) && !empty($_POST["psc"])) {
    $kosik_pole = kosik($db);
    if (!empty($kosik_pole)) {
      $iduzivatel = $_SESSION['idUzivatel'];
      $date = date('Y-m-d');
      $mesto = $_POST['mesto'];
      $adresa = $_POST['adres_cp'];
      $psc = $_POST['psc'];
      $query = "INSERT INTO objednavky(uzivatel_iduzivatel,datum, mesto, adresa_cp, psc) VALUES (?,?,?,?,?)";
      $stmt = $db->prepare($query);
      $stmt->bind_param("sssss", $iduzivatel, $date, $mesto, $adresa, $psc);
      $stmt->execute();


      $query = "SELECT MAX(idobjednavky) AS idobjednavky FROM objednavky;";
      $stmt = $db->prepare($query);
      $stmt->execute();
      $last_id = $stmt->get_result()->fetch_assoc();
      foreach ($kosik_pole as $produkt_kosik) {



        $idproduktkosik = $produkt_kosik["idProdukt"];
        $velikostproduktkosik = $produkt_kosik['velikost'];
        $pocetproduktkosik = $produkt_kosik['pocet'];

        $query = "INSERT INTO objednavky_has_produkt (objednavky_idobjednavky, produkt_idprodukt, velikost, pocet) VALUES (?,?,?,?)";
        $stmt = $db->prepare($query);
        $stmt->bind_param("ssss", $last_id["idobjednavky"], $idproduktkosik,  $velikostproduktkosik,  $pocetproduktkosik);
        $stmt->execute();
      }


      $query = "DELETE FROM kosik WHERE uzivatel_iduzivatel=?";
      $stmt = $db->prepare($query);
      $stmt->bind_param("s", $iduzivatel);
      $stmt->execute();
    }
  }
