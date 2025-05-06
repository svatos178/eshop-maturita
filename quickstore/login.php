<?php


include("head.php");
include('server.php');
include("navbar.php");

?>
<html>
<body>
  <div class="main container">
    <h3>Login</h3>
    <form method="post" action="login.php">
      <?php include('chyby.php');
      
      ?>
      <div class="form-group">
        <label for="email"> Email:
        </label>
        <input type="email" class="form-control custom-form" name="email" required>

      </div>
      <div class="form-group">
        <label for="heslo">Heslo:</label>
        <input type="password" class="form-control" name="heslo" required>

      </div>
      <div class="form-group from-check">

      </div>
      <button type="submit" name="login" class="btn btn-primary custom-button">Přihlásit se</button>
      <p>Nemáte ještě účet ? Registrujte se <a href="register.php">zde</a></p>
    </form>
  </div>
  <?php
  include("footer.php");
  ?>
</body>

</html>