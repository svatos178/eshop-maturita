<footer class="footer">
    <div class="row">
      <div class="col-lg-3 col-12 mx-auto">
        <h5 class="text-uppercase">quickstore</h5>
        <p> Váš jednoduchý online obchod</p>
      </div>
      <div class="col-lg-3 col-12 mx-auto" style="padding-bottom:20px">
        <h5 class="text-uppercase">informace</h5>
        <a href="info.php" class="footer">O nás</a>
      </div>
      <div class="col-lg-2 col-12 mx-auto">
        <h5 class="text-uppercase">účet</h5>
        <div class="d-flex flex-column flex-wrap">
        <?php if (isset($_SESSION['idUzivatel'])) : ?>
          <a href="user.php" class="footer">Můj účet</a>
          <a href="historieObjednavek.php" class="footer">Historie nákupů</a>
          <?php else : ?>
            <a href="login.php" class="footer">Login</a>
            <a href="register.php" class="footer">Registrace</a>
          <?php endif ?>
        </div>
      </div>
    </div>
</footer>