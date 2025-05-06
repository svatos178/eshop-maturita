<?php
include("head.php");
include('server.php');
include("navbar.php");
include_once("kontrola_admin.php");
include("chyby.php");

?>

<html>
<body>
    <div class="main container">

    <?php include("success_message.php"); ?>

    <form class="userform" method="post" action="produkt_pridani.php" enctype='multipart/form-data'>
      <div class="form-group">
        <label> Jméno: </label>
        <input type="text" class="form-control custom-form" name="jmenoProdukt" required>
      </div>
      <div class="form-group">
      <label> Popis: </label>
        <input type="text" class="form-control custom-form" name="popisProdukt" required>
      </div>
      <div class="form-group">
      <label> Cena: </label>
        <input type="number" class="form-control custom-form" name="cenaProdukt" required>
      </div>
      <div class="form-group">
        <label> Obrázek: </label>
        <input type="file" class="btn btn-primary my-2 my-sm-0" name="fotka" required>
      </div>
      <div class="form-group">
      <label> Kategorie: </label>
        <input type="text" class="form-control custom-form" name="kategorieProdukt" required>
      </div>
      <div class="form-group">
      <label> Značka: </label>
        <input type="text" class="form-control custom-form" name="znackaProdukt" required>
      </div>
      <div class="form-group">
      <label> Barva: </label>
        <input type="text" class="form-control custom-form" name="barvaProdukt" required>
      </div>
      <div class="form-group">
      <label> Pohlaví: </label>
        <input type="text" class="form-control custom-form" name="pohlaviProdukt" required>
      </div>
      <button type="submit"  name="pridani-produkt" class="btn btn-primary custom-button">přidat</button>
     
    </form>

  </div>
  <?php 
   include("footer.php");
    ?>
</body>
</html>