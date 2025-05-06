<?php
include("head.php");
include('server.php');
include("navbar.php");
include_once("kontrola_admin.php");
include("chyby.php");


$idProdukt = $_GET["id"];
$stmt = $db->prepare("SELECT * FROM produkt WHERE idProdukt=?");
$stmt->bind_param("s", $idProdukt);
$stmt->execute();
$produkt = $stmt->get_result()->fetch_assoc();

if (!$uzivatel) {
  header("location: index.php");
}

$jmenoProdukt = $produkt['jmenoProdukt'];
$popisProdukt = $produkt['popisProdukt'];
$cenaProdukt = $produkt['cenaProdukt'];
$imageProdukt = $produkt['imageProdukt'];
$kategorieProdukt = $produkt['kategorieProdukt'];
$znackaProdukt = $produkt['znackaProdukt'];
$barvaProdukt = $produkt['barvaProdukt'];
$pohlaviProdukt = $produkt['pohlaviProdukt'];

?>

<html>
<body>
    <div class="main container">

    <?php include("success_message.php");
 ?>

    <form class="userform" method="post" action="produkt_prepsani.php?id=<?php echo htmlspecialchars($idProdukt); ?>" enctype='multipart/form-data'>
      <div class="form-group">
        <label for="email"> Jméno: </label>
        <input type="text" class="form-control custom-form" name="jmenoProdukt" value="<?php echo htmlspecialchars($jmenoProdukt); ?>" required>
      </div>
      <div class="form-group">
        <label for="email"> Popis: </label>
        <input type="text" class="form-control custom-form" name="popisProdukt" value="<?php echo htmlspecialchars($popisProdukt); ?>" required>
      </div>
      <div class="form-group">
        <label for="email"> Cena: </label>
        <input type="text" class="form-control custom-form" name="cenaProdukt" value="<?php echo htmlspecialchars($cenaProdukt); ?>" required>
      </div>
      <div class="form-group">
        <label> Obrázek: </label> <br>
        <img src="<?= htmlspecialchars($imageProdukt) ?>" style="width: 300px;">
      </div>
      <input type="text" name="imageProdukt" value="<?= htmlspecialchars($imageProdukt) ?>" hidden>
      <div class="form-group">
        <label> Změnit obrázek: </label>
        <input type="file" class="btn btn-primary my-2 my-sm-0" name="fotka">
      </div>
      <div class="form-group">
        <label for="email"> Kategorie: </label>
        <input type="text" class="form-control custom-form" name="kategorieProdukt" value="<?php echo htmlspecialchars($kategorieProdukt); ?>" required>
      </div>
      <div class="form-group">
        <label for="email"> Značka: </label>
        <input type="text" class="form-control custom-form" name="znackaProdukt" value="<?php echo htmlspecialchars($znackaProdukt); ?>" required>
      </div>
      <div class="form-group">
        <label for="email"> Barva: </label>
        <input type="text" class="form-control custom-form" name="barvaProdukt" value="<?php echo htmlspecialchars($barvaProdukt); ?>" required>
      </div>
      <div class="form-group">
        <label for="email"> Pohlaví: </label>
        <input type="text" class="form-control custom-form" name="pohlaviProdukt" value="<?php echo htmlspecialchars($pohlaviProdukt); ?>" required>
      </div>
      <button type="submit"  name="zmenaudaju-produkt" class="btn btn-primary custom-button">Uložit změny</button>
      <button type="submit"  name="smazani-produkt" class="btn btn-primary custom-button">Smazat produkt</button>
    </form>

  </div>
  <?php 
   include("footer.php");
    ?>
</body>
</html>