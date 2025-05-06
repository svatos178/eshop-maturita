<?php
include("head.php");
include('server.php');
include("navbar.php");

?>
<html>

<body>
  <?php
  $idProdukt = $_GET["id"];
  $produkt = ("SELECT * FROM produkt WHERE idProdukt=? LIMIT 1");
  $stmt = $db->prepare($produkt);
  $stmt->bind_param("s", $idProdukt);
  $stmt->execute();
  $produktVypis = $stmt->get_result()->fetch_assoc();

  function odesli_kosik()
  {
    if (isset($_POST['submit_kosik']) && $_POST['pocetProdukt_kosik'] >= 1 && $_POST['velikostProdukt_kosik']) {
      $db = mysqli_connect("db.mp.spse-net.cz","svatosad","pysuchesifuma","svatosad_1");
      //$db = mysqli_connect('127.0.0.1:3308', 'root', "", 'mydb');
      mysqli_set_charset($db, "utf8_czech_ci");
      if ($db->connect_error) {
        die("chyba při připojování k databázi" . $db->connect_error);
      }
      $pole_post = $_POST;

      $query = "INSERT INTO kosik (uzivatel_iduzivatel, produkt_idprodukt, velikost, pocet) 
                  VALUES(?, ?, ?, ?)";
      $stmt = $db->prepare($query);
      $stmt->bind_param("ssss", $_SESSION['idUzivatel'], $pole_post['idProdukt_kosik'], $pole_post['velikostProdukt_kosik'], $pole_post['pocetProdukt_kosik']);
      $stmt->execute();
    }
  }


  odesli_kosik();

  ?>
  <div class="main">

    <form action="" method="post">
      <section class="mb-5 popis-vrsek">
        <div class="row">
          <div class="col-md-6 mb-4 mb-md-0">
            <img src="<?php echo $produktVypis['imageProdukt'] ?>" alt="foto produktu" class="img-fluid" />
          </div>
          <div class="col-md-6">
            <h1 class="text-uppercase nazev-produkt" style="padding-top: 2px;"><?php echo $produktVypis['jmenoProdukt'] ?></h1>
            <?php if (isset($_SESSION['idUzivatel']) && $uzivatel['email'] === "admin@email.cz") : ?>
              <li class="border-0">
                <p class="nazev-produkt">ID: <?php echo $produktVypis['idProdukt'] ?></p>
              </li>
            <?php endif ?>
            <ul class="list-group">
              <li class="border-0 produkt-misto">Značka: <?php echo $produktVypis['znackaProdukt'] ?></li>
              <li class="border-0 produkt-misto">Kategorie: <?php echo $produktVypis['kategorieProdukt'] ?></li>
              <li class="border-0 produkt-misto">Barva: <?php echo $produktVypis['barvaProdukt'] ?></li>
              <li class="border-0 produkt-misto">pohlaví: <?php echo $produktVypis['pohlaviProdukt'] ?></li>
            </ul>
            <p class="mb-2 text-muted text-uppercase small popis-top "> <?php echo $produktVypis['popisProdukt'] ?> </p>
            <p><span class="text-danger mr-1 popis-produkt"><?php echo $produktVypis['cenaProdukt'] ?> Kč</span></p>

            <?php if (isset($_SESSION['idUzivatel'])) { ?>
              <div class="table-responsive mb-2 ">
                <table class="table table-sm table-borderless border-0">
                  <tbody>
                    <tr>
                      <td class="pl-0 pb-0 w-25 modra">Počet: </td>
                    </tr>
                    <tr>
                      <td class="pl-0">
                        <input class="quantity modra" min="1" name="pocetProdukt_kosik" value="1" type="number" required="required">
                      </td>
                      <td>
                        <div>
                          <span>
                            <span class="modra">Vyberte velikost</span>
                            <select class="modra vyska30" name="velikostProdukt_kosik" style="width: 60px;">
                              <option value="xs">XS</option>
                              <option value="s">S</option>
                              <option selected value="m">M</option>
                              <option value="l">L</option>
                              <option value="xl">XL</option>
                              <option value="xxl">XXL</option>
                            </select>
                          </span>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
                <input type="hidden" value="<?php echo $produktVypis['idProdukt']; ?>" name="idProdukt_kosik">
                <input type="hidden" value="<?php echo $produktVypis['jmenoProdukt']; ?>" name="jmenoProdukt_kosik">
                <input type="hidden" value="<?php echo $_SESSION['idUzivatel']; ?>" name="idUzivatel_kosik">

                <input type="submit" name="submit_kosik" value="Přidejte do košíku" class="btn btn-primary custom-button">
                <?php if (isset($_POST["submit_kosik"])) { ?>
                  <p id="cart_msg" style="color: red;">Přidáno do košíku.</p>
                  <script>
                    setTimeout(() => {
                    $("#cart_msg").remove();
                    }, 3500);
                  </script>
                <?php } ?>
              </div>
          </div>
         
        <?php } else { ?>
        <div>
            <h2 class="error">pro přidání do košíku se přihlaste</h2>
          </div>
          <?php } ?>
        </div>
      </section>
    </form>
  </div>

  <?php
  include("footer.php");
  ?>

</body>

</html>