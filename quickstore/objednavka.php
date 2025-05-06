<?php
include("head.php");
include("server.php");
include("navbar.php");

?>
<html>

<body>
    <main class="main">

        <?php

        $celkem = 0;
        function objednavkyFunkce($db): array
        {
            $idobjednavky = $_POST["idobjednavky"];
            $objednavkaVyber = "SELECT produkt.idProdukt, produkt.jmenoProdukt, produkt.cenaProdukt, produkt.imageProdukt,
 produkt.kategorieProdukt, produkt.znackaProdukt, produkt.barvaProdukt, produkt.pohlaviProdukt, objednavky_has_produkt.produkt_idprodukt, objednavky_has_produkt.velikost,
  objednavky_has_produkt.pocet, objednavky_has_produkt.objednavky_idobjednavky
  FROM produkt JOIN objednavky_has_produkt ON produkt.idProdukt = objednavky_has_produkt.produkt_idprodukt WHERE objednavky_has_produkt.objednavky_idobjednavky = ?";

            $stmt = $db->prepare($objednavkaVyber);
            $stmt->bind_param("s", $idobjednavky);
            $stmt->execute();
            $objednavka_pole = [];
            $objednavkastmt = $stmt->get_result();
            while ($row = $objednavkastmt->fetch_assoc()) {
                array_push($objednavka_pole, $row);
            }
            return $objednavka_pole;
        }

        ?>




        <?php
        $objednavka_pole = objednavkyFunkce($db);
        for ($i = 0; $i < count($objednavka_pole); $i++) {
            $value = $objednavka_pole[$i];
            $idObjednavka = $objednavka_pole[$i]["objednavky_idobjednavky"];
        ?> <div class="objednavka stred">

                <div class="row">
                    <div class="col-md-12  mb-12">
                        <h4 class="d-flex justify-content-between align-items-center mb-3">
                        </h4>
                        <ul class="list-group mb-6">
                            <li class="list-group-item d-flex justify-content-between lh-condensed spodek " id="<?= $objednavka_pole[$i]["objednavky_idobjednavky"] ?>">
                                <div>
                                    <h4 class="my-0 kosik-jmeno div-button"> <?php echo $objednavka_pole[$i]["jmenoProdukt"]; ?> </h4>


                                    <div class="popis-vrsek odsazeni">
                                        <h4 class="my-4 div-button">velikost:
                                            <?php echo $objednavka_pole[$i]["velikost"]; ?> </h4>
                                    </div>

                                    <div>
                                        <h4 class="objednavka-bottom">počet:
                                            <?php echo $objednavka_pole[$i]["pocet"]; ?></h4>
                                    </div>

                                </div>
                                <div>
                                    <span><?php echo number_format((int)  $objednavka_pole[$i]["cenaProdukt"] * ((int) $objednavka_pole[$i]["pocet"]), 2, '.', ' '); ?>&nbsp;Kč
                                        </br>


                                    </span>
                                </div>

                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        <?php
            $celkem += ((int) $objednavka_pole[$i]["cenaProdukt"]) * ((int) $objednavka_pole[$i]["pocet"]);
        }

        ?>

        <div class="center">
            <h3 class="objednavka-bottom error">celková cena:
                <?php echo number_format((int) $celkem, 2, '.', ' '); ?>&nbsp;Kč</h3>


                <?php  if (isset($_SESSION['idUzivatel']) && $email === "admin@email.cz") {
    ?>
                <h3><a href="objednavky.php">zpět na objednávky</a></h3>
            <?php  } else {
?>
<h3><a href="historieObjednavek.php">zpět na objednávky</a></h3>
           <?php } ?> 
         
        </div>

    </main>
    <?php include("footer.php");
    ?>
</body>

</html>