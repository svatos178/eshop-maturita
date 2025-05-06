<?php


include("head.php");
include('server.php');
include("navbar.php");

?>
<!DOCTYPE html>
<html>




<body>
    <div class="main container">
        <h3>Registrace</h3>
        <form method="post" action="register.php">
            <?php include('chyby.php'); ?>
            <div class="form-group">
                <label for="email"> Jméno:
                </label>
                <input type="text" class="form-control custom-form" name="jmeno"  required>

            </div>

            <div class="form-group">
                <label for="email"> Příjmení:
                </label>
                <input type="text" class="form-control custom-form" name="prijmeni" required>

            </div>

            <div class="form-group">
                <label for="email"> Email:
                </label>
                <input type="email" class="form-control custom-form" name="email" required>

            </div>

            <div class="form-group">
                <label for="heslo">Heslo:</label>
                <input type="password" class="form-control" name="heslo_1" required>
            </div>

            <div class="form-group">
                <label for="heslo">Potvrzení hesla:</label>
                <input type="password" class="form-control" name="heslo_2" required>
            </div>

            <button type="submit" class="btn btn-primary custom-button" name="register">Registrace</button>
            <p>Máte již účet ? Přihlaste se <a href="login.php">zde</a></p>
        </form>
    </div>

  <?php
  include("footer.php");
  ?>
</body>

</html>