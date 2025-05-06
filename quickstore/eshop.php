<?php
$isEshopPage = true;
include("head.php");
include('server.php');
include("navbar.php");
?>

<html>

<body>
  <main class="main">
    <div class="row popis-vrsek">
      <div class=" d-flex col-md-3 col-sm-4 col-lg-2">
        <form class="needs-validation" novalidate method="GET" enctype="multipart/form-data">
          <div class="pb-3 filtr-width">
            <input class="form-control mr-sm-2" type="search" placeholder="vyhledávání" aria-label="Search" name="hledat" value="<?= isset($_GET["hledat"]) ? $_GET["hledat"] : "" ?>">
          </div>
          <div class="filtr-width pb-3">
            <div class="doporucujeme-filtr text-uppercase ">
              <h3 class="filtr-center">oblečení</h3>
            </div>
            <div class=" d-flex pb-3">

              <ul class="list-group">
                <?php $kategorie = "SELECT DISTINCT kategorieProdukt FROM produkt ORDER BY kategorieProdukt";
                $stmt = $db->prepare($kategorie);
                $stmt->execute();
                $results = $stmt->get_result()->fetch_all();
                foreach ($results as $result) {

                ?>
                  <li class="list-group-item filtr-width">
                    <div class=form-check>
                      <label class="from-check-label">
                        <input type="checkbox" class="form-check-input product-check" name="kategorieProdukt[]" value="<?= $result[0]; ?>" <?php if (isset($_GET["kategorieProdukt"])) {
                          if (in_array($result[0], $_GET['kategorieProdukt'])) {
                            echo ("checked");
                          }
                        };
                        ?> id="kategorieProdukt"><?= $result[0]; ?>



                      </label>
                    </div>
                  </li>
                <?php } ?>
              </ul>
            </div>
            <div class="doporucujeme-filtr text-uppercase ">
              <h3 class="filtr-center">značka</h3>
            </div>
            <div class=" d-flex pb-3">

              <ul class="list-group">
                <?php $kategorie = "SELECT DISTINCT znackaProdukt FROM produkt ORDER BY znackaProdukt";
                $stmt = $db->prepare($kategorie);
                $stmt->execute();
                $results = $stmt->get_result()->fetch_all();
                foreach ($results as $result) {

                ?>
                  <li class="list-group-item filtr-width">
                    <div class=form-check>
                      <label class="from-check-label">
                        <input type=checkbox class="form-check-input product-check" value="<?= $result[0]; ?>" id="znackaProdukt" name="znackaProdukt[]" <?php if (isset($_GET["znackaProdukt"])) {
                                                                                                                                                            if (in_array($result[0], $_GET['znackaProdukt'])) {
                                                                                                                                                              echo ("checked");
                                                                                                                                                            }
                                                                                                                                                          };
                                                                                                                                                          ?>><?= $result[0]; ?>

                      </label>
                    </div>
                  </li>
                <?php
                }
                ?>

              </ul>
            </div>
            <div class="doporucujeme-filtr text-uppercase ">
              <h3 class="filtr-center">barva</h3>
            </div>
            <div class=" d-flex pb-3">

              <ul class="list-group">
                <?php $kategorie = "SELECT DISTINCT barvaProdukt FROM produkt ORDER BY barvaProdukt";
                $stmt = $db->prepare($kategorie);
                $stmt->execute();
                $results = $stmt->get_result()->fetch_all();
                foreach ($results as $result) {

                ?>
                  <li class="list-group-item filtr-width">
                    <div class=form-check>
                      <label class="from-check-label">
                        <input type=checkbox class="form-check-input product-check" value="<?= $result[0]; ?>" id="barvaProdukt" name="barvaProdukt[]" <?php if (isset($_GET["barvaProdukt"])) {
                                                                                                                                                          if (in_array($result[0], $_GET['barvaProdukt'])) {
                                                                                                                                                            echo ("checked");
                                                                                                                                                          }
                                                                                                                                                        };
                                                                                                                                                        ?>><?= $result[0]; ?>

                      </label>
                    </div>
                  </li>
                <?php
                }
                ?>

              </ul>
            </div>
            <div class="doporucujeme-filtr text-uppercase ">
              <h3 class="filtr-center">pohlaví</h3>
            </div>
            <div class=" d-flex pb-3">

              <ul class="list-group">
                <?php $kategorie = "SELECT DISTINCT pohlaviProdukt FROM produkt ORDER BY pohlaviProdukt";
                $stmt = $db->prepare($kategorie);
                $stmt->execute();
                $results = $stmt->get_result()->fetch_all();
                foreach ($results as $result) {

                ?>
                  <li class="list-group-item filtr-width">
                    <div class=form-check>
                      <label class="from-check-label">
                        <input type=checkbox class="form-check-input product-check" value="<?= $result[0]; ?>" id="pohlaviProdukt" name="pohlaviProdukt[]" <?php if (isset($_GET["pohlaviProdukt"])) {

                                                                                                                                                              if (in_array($result[0], $_GET['pohlaviProdukt'])) {
                                                                                                                                                                echo ("checked");
                                                                                                                                                              }
                                                                                                                                                            };
                                                                                                                                                            ?>><?= $result[0]; ?>
                      </label>
                    </div>
                  </li>
                <?php
                }
                ?>
              </ul>
            </div>

            <div class="doporucujeme-filtr text-uppercase ">
              <h3 class="filtr-center">Cena</h3>
            </div>
            <div class=" d-flex pb-3 ">



              <div class="card filtr-width vyska-cena">
                <div class="col-xs-4 form-group">
                  <label for="cenaProduktMin"> Minimální cena </label>
                  <?php
                  $result = $db->query("SELECT MIN(cenaProdukt) AS minCena, MAX(cenaProdukt) AS maxCena FROM produkt")->fetch_assoc();
                  $min = !empty($_GET["cenaProduktMin"]) ? $_GET["cenaProduktMin"] : $result["minCena"];
                  $max = !empty($_GET["cenaProduktMax"]) ? $_GET["cenaProduktMax"] : $result["maxCena"];
                  ?>
                  <input type="number" class="form-control" value="<?= $min ?>" id="cenaProduktMin" name="cenaProduktMin" min="<?= $min ?>" max="<?= $max ?>">

                </div>
                <div class="form-group">
                  <label> Maximální cena </label>
                  <input type="number" class="form-control" id="cenaProduktMax" value="<?= $max ?>" name="cenaProduktMax" min="<?= $min ?>" max="<?= $max ?>">

                </div>
              </div>



            </div>

            <div class=" d-flex pb-3">
              <ul class="list-group ">
                <li class="list-group-item filtr-width">
                  <!--div class=form-check-->
                  <label class="form-check-label" style="margin: 4px;">
                    <input type="submit" class="center-input btn btn-primary custom-button" value="Potvrdit výběr" name="vyber_submit" id="vyberfilter">
                  </label>
                  <label class="from-check-label" style="margin: 4px;">
                    <input type="submit" class="center-input btn btn-primary custom-button" value="Smazat výběr" name="delete_vyber_submit">
                  </label>
                  <!--/div-->
                </li>
              </ul>
            </div>

          </div>
        </form>
      </div>


      <div class="row col-md-9 col-sm-8 col-lg-10">

        <?php
        $arr_produkt = poleProdukt($db);

        for ($i = 0; $i < count($arr_produkt); $i++) {
          $value = $arr_produkt[$i];

        ?>
          <div class="col-md-4 col-lg-3 d-flex pb-3" style="max-height: 600px;">
            <div class="card mb-4 lg-3 w-100">
              <form action="" method="post">
                <a href="produkt.php?id=<?php echo ($value['idProdukt']) ?>">

                  <img id="imgprodukt" src="<?php echo import_file($value['imageProdukt']); ?>" alt="" srcset="" class="card-img-top card-img-sizing">
                </a>
                <div class="card-body ">
                  <p class="card-text ">
                    <a href="produkt.php?id=<?php echo ($value['idProdukt']) ?>">
                      <h2 class="nazev-produkt"><?php echo $value['jmenoProdukt']; ?></h2>
                    </a>
                    <?php if (isset($_SESSION['idUzivatel']) && $email === "admin@email.cz") {
                    ?>
                  <h6 class="text-secondary">
                    <?php
                      echo "ID produktu: " .  $value['idProdukt'];
                    ?>
                  </h6>
                <?php  } ?>
                <div class=" overflow-auto " style="font-size: 13px; max-height: 90px; min-height: 90px; ">
                  <?php echo $value['popisProdukt']; ?><br>
                </div>
                <h5 class="text-danger cena-polozky"><?php echo number_format((int) $value["cenaProdukt"], 2, '.', ' '); ?>&nbsp;Kč</h5>
                </p>
                </div>
              </form>
            </div>
          </div>
        <?php
        }
        ?>
      </div>

    </div>
  </main>

  <?php
  include("footer.php");
  ?>

</body>

<script>
  $("[name=delete_vyber_submit]").click((e) => {
    e.preventDefault();
    window.location.replace("eshop.php");
  });
</script>

</html>