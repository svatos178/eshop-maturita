<?php


include("head.php");
include('server.php');
include("navbar.php");
include_once("kontrola_admin.php");
include("chyby.php");

$idUzivatel = $_GET["id"];

$stmt = $db->prepare("SELECT * FROM uzivatel WHERE idUzivatel=?");
$stmt->bind_param("s", $idUzivatel);
$stmt->execute();
$uzivatel = $stmt->get_result()->fetch_assoc();

if (!$uzivatel) {
  header("location: index.php");
}

$jmeno = $uzivatel['jmeno'];
$prijmeni = $uzivatel['prijmeni'];
$email = $uzivatel['email'];

?>

<html>
<body>
    <div class="main container">

    <?php include("success_message.php"); ?>

    <form class="userform" method="post" action="upravit_uzivatele.php?id=<?php echo htmlspecialchars($idUzivatel); ?>">
      <div class="form-group">
        <label for="email"> Jméno uživatele: </label>
        <input type="text" class="form-control custom-form" name="jmeno" value="<?php echo htmlspecialchars($jmeno); ?>" required>
      </div>
      <div class="form-group">
        <label for="email"> Příjmení uživatele: </label>
        <input type="text" class="form-control custom-form" name="prijmeni" value="<?php echo htmlspecialchars($prijmeni); ?>" required>
      </div>
      <div class="form-group">
        <label for="email"> Email uživatele: </label>
        <input type="email" class="form-control custom-form" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
      </div>
      <button type="submit"  name="zmenaudaju-id" class="btn btn-primary custom-button">Změnit údaje</button>
      <button type="submit"  name="smazani-id" class="btn btn-primary custom-button">Smazat uživatele</button>
    </form>

  </div>
  <?php 
   include("footer.php");
    ?>
</body>
</html>