<?php
include("head.php");
include('server.php');
include("navbar.php");
include_once("kontrola_admin.php");
$headers = "Content-Type: text/html; charset=UTF-8";

if (isset($_GET['idObjednavky'])) {
    $idObjednavky = $_GET['idObjednavky'];

    if (isset($_GET["smazani"])) {
        $stmt = $db->prepare("DELETE FROM objednavky WHERE idobjednavky = ?");
        $stmt->bind_param("s", $idObjednavky);
        $stmt->execute();
        header("location: objednavky.php");
    } else {
        $stmt = $db->prepare("SELECT uzivatel.* FROM objednavky JOIN
            uzivatel ON uzivatel.idUzivatel = objednavky.uzivatel_iduzivatel WHERE objednavky.idobjednavky=?");
        $stmt->bind_param("s", $idObjednavky);
        $stmt->execute();
        $user = $stmt->get_result()->fetch_assoc();

        $kosikstmt = $db->prepare("
        SELECT * FROM objednavky o
        JOIN objednavky_has_produkt ohp ON o.idobjednavky = ohp.objednavky_idobjednavky
        JOIN produkt p ON p.idProdukt = ohp.produkt_idprodukt
        WHERE o.idobjednavky = ?");
        $kosikstmt->bind_param("s", $idObjednavky);
        $kosikstmt->execute();
        $kosik = $kosikstmt->get_result()->fetch_all();




        $datum = $kosik[0][2];
        $mesto = $kosik[0][3];
        $adresa = $kosik[0][4];
        $psc = $kosik[0][5];
        foreach ($kosik as $produkt) {
            $messeges[] = "Produkt: $produkt[12], počet:$produkt[10], velikost:  $produkt[9], cena: "  . number_format((int)($produkt[10]*$produkt[14]), 2, '.', ' ') . " Kč";
            $ceny[] = $produkt[10]*$produkt[14];
         

            
        }
        $prehled = implode("\n", $messeges);
        $celkem = array_sum($ceny);


        if (!in_array($_SERVER['REMOTE_ADDR'], ['127.0.0.1', '::1'])) {
            $jmeno = $user["jmeno"];
            $prijmeni = $user["prijmeni"];
            $email_address = $user["email"];
            $message = "Shrnutí objednávky:\n$prehled";
            $to = $email_address;
            $email_subject = "Quickstore";
            $email_body = "Zasíláme Vám fakturu k Vaší objednávce s číslem $idObjednavky.\n Datum objednání: $datum\n Město: $mesto, PSČ: $psc\n Adresa: $adresa\n"
            . "Jméno: $jmeno\nPříjmení: $prijmeni\n\n$message \nCelková cena: " . number_format((int)$celkem, 2, '.', ' ') . " Kč";
            $headers["From"] = "noreply@quickstore.com";
            $headers["Reply-To"] = $email_address;
            mail($email_address, $email_subject, $email_body, $headers);
        }

        $query = "UPDATE objednavky SET odeslano=1 WHERE idobjednavky=?";
        $stmt = $db->prepare($query);
        $stmt->bind_param("s", $idObjednavky);
        $stmt->execute();

        header("location: objednavky.php");
    }
}

?>

<html>

<body>
    <main class="main">


        <div class="main container">


            <form class="userform" method="post" action="objednavka.php">
                <?php

                $objednavky = mysqli_query($db, "SELECT idobjednavky, uzivatel_iduzivatel, datum, mesto, adresa_cp, psc, odeslano FROM objednavky ORDER BY odeslano");
                ?>

                <div class="container popis-top">
                    <table class="objednavky">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th class="d-none d-sm-table-cell">ID uživatele </th>
                                <th class="d-none d-md-table-cell">Datum </th>
                                <th class="d-none d-md-table-cell"> Město </th>
                                <th class="d-none d-md-table-cell">Adresa a č.p.</th>
                                <th class="d-none d-md-table-cell">PSČ</th>
                                <th class="d-none d-sm-table-cell">Stav objednávky</th>
                                <th>Objednávka</th>
                                <th>Odeslání</th>
                                <th>Smazání</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($objednavky as $vypis) : ?>
                                <?php
                                if ($vypis['odeslano'] == 0) {
                                    $odeslani = "Čeká se na vyřízení";
                                } else {
                                    $odeslani = "Objednávka je odeslána";
                                }
                                ?>
                                <tr>

                                    <td><?php echo htmlspecialchars($vypis['idobjednavky']) ?></td>
                                    <td class="d-none d-sm-table-cell"><?php echo htmlspecialchars($vypis['uzivatel_iduzivatel']) ?></td>
                                    <td class="d-none d-md-table-cell"><?php echo htmlspecialchars($vypis['datum']) ?></td>
                                    <td class="d-none d-md-table-cell"><?php echo htmlspecialchars($vypis['mesto']) ?></td>
                                    <td class="d-none d-md-table-cell"><?php echo htmlspecialchars($vypis['adresa_cp']) ?></td>
                                    <td class="d-none d-md-table-cell"><?php echo htmlspecialchars($vypis['psc']) ?></td>
                                    <td class="d-none d-sm-table-cell"><?php echo htmlspecialchars($odeslani) ?></td>
                                    <td> <button class="btn btn-primary my-2 my-sm-0 custom-button" value="<?php echo $vypis['idobjednavky'] ?>" name="idobjednavky">Zobrazit</button>
                                    </td>
                                    <td>
                                        <?php if ($vypis['odeslano'] == 0) {
                                        ?>
                                            <button class="btn btn-primary custom-button odeslani" value="<?php echo $vypis['idobjednavky'] ?>" name="odeslani">
                                                Odeslat objednávku</button>
                                        <?php
                                        } else {
                                        ?> <p>Odesláno</p>
                                        <?php
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?php if ($vypis['odeslano'] == 0) {
                                        ?>
                                            <button class="btn btn-primary custom-button smazani" formaction="objednavky.php" value="<?php echo $vypis['idobjednavky'] ?>" name="smazani">
                                               Smazat</button>
                                        <?php
                                        } else {
                                        ?> <p>Nelze smazat odeslanou objednávku</p>
                                        <?php
                                        }
                                        ?>
                                    </td>


                                </tr>
                            <?php



                            endforeach ?>
                        </tbody>
                    </table>
                </div>
            </form>
        </div>


    </main>
    <?php include("footer.php");
    ?>

</body>

</html>
<script>
    $(".odeslani").click(function(e) {
        e.preventDefault();
        if (confirm("Opravdu chcete odeslat objednávku?")) {
            window.location.href = `?idObjednavky=${e.target.value}`;
        }
    });

    $(".smazani").click(function(e) {
        e.preventDefault();
        if (confirm("Opravdu chcete odeslat objednávku?")) {
            window.location.href = `?smazani&idObjednavky=${e.target.value}`;
        }
    });
</script>