<?php

include("head.php");
include('server.php');
include("navbar.php");
include("chyby.php");

if (!isset($_SESSION['idUzivatel'])) {
  header("location: index.php");
}

?>
<html>
<body>
    <div class="main container">

    <?php include("success_message.php"); ?>

    <form class="userform" method="post" action="user.php">
      <div class="form-group">
        <label for="email"> Jméno: </label>
        <input type="text" class="form-control custom-form" name="jmeno" value="<?php echo htmlspecialchars($jmeno) ?>" required>
      </div>
      <div class="form-group">
        <label for="email"> Příjmení: </label>
        <input type="text" class="form-control custom-form" name="prijmeni" value="<?php echo htmlspecialchars($prijmeni) ?>" required>
      </div>
      <div class="form-group">
        <label for="email"> Email: </label>
        <input type="email" class="form-control custom-form" name="email" value="<?php echo htmlspecialchars($email) ?>" required>
      </div>
      <button type="submit" name="zmenaudaju" class="btn btn-primary custom-button">Změnit údaje</button>
    </form>

    <form class="userform" method="post" action="user.php">
      <div class="form-group">
      <div class="form-group">
        <label for="heslo">Staré heslo: </label>
        <input type="password" class="form-control" name="heslo" required>
      </div>
      <div class="form-group">
        <label for="heslo">Nové heslo: </label>
        <input type="password" class="form-control" name="heslo_1" required>
      </div>
      <div class="form-group">
        <label for="heslo">Nové heslo znovu: </label>
        <input type="password" class="form-control" name="heslo_2" required>
      </div>

      </div>
      <div class="form-group from-check">

      </div>
      <button type="submit" name="zmenahesla" class="btn btn-primary custom-button">Změnit heslo</button>
    </form>




  </div>
  <?php 
   include("footer.php");
    ?>
</body>
</html>