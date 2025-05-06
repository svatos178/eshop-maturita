<?php
include("head.php");
define('DB_SERVER', 'db.mp.spse-net.cz');
define('DB_USERNAME', 'svatosad');
define('DB_PASSWORD', 'pysuchesifuma');
define('DB_NAME', 'svatosad_1');
function getdb()
{
    try {
        $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME . ";charset=UTF8", DB_USERNAME, DB_PASSWORD);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("ERROR: Could not connect. " . $e->getMessage());
    }
    return $pdo;
}
function operation(string $query, ...$params)
{
    $stmt = getdb()->prepare($query);
    $stmt->execute($params);
    return $stmt;
}
function queryall(string $query, ...$params)
{
    $stmt = operation($query, ...$params);
    return $stmt->fetchAll();
}
function query(string $query, ...$params)
{
    $stmt = operation($query, ...$params);
    return $stmt->fetch();
}

$iduz = $_SESSION['idUzivatel'];
$uzivatel = query("SELECT * FROM uzivatel WHERE idUzivatel=?", $iduz);

   
    ?>
<html>

<body>
<?php include("navbar.php");?>

    <main class="main">

        <div class="main container">

            <form class="userform" method="post" action="objednavka.php">
                <?php
                $iduzivatele = $_SESSION['idUzivatel'];
                $produkt = queryall("SELECT idobjednavky, uzivatel_iduzivatel, datum, mesto, adresa_cp, psc, odeslano FROM objednavky WHERE uzivatel_iduzivatel=?
                ORDER BY odeslano", $iduzivatele);

                ?>

                <div class="container popis-top">
                    <table class="objednavky">
                        <thead>
                            <tr>
                                <th>Číslo objednávky</th>
                                <th class="d-none d-md-table-cell">Datum </th>
                                <th class="d-none d-md-table-cell"> Město </th>
                                <th class="d-none d-md-table-cell">Adresa a č.p.</th>
                                <th class="d-none d-md-table-cell">PSČ</th>
                                <th class="d-none d-sm-table-cell">Stav objednávky</th>
                                <th>Objednávka</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($produkt as $vypisy) : ?>
                                <?php
                                if ($vypisy['odeslano'] == 0) {
                                    $odeslani = "Čeká se na vyřízení";
                                } else {
                                    $odeslani = "Objednávka je odeslána";
                                }
                                ?>
                                <tr>

                                    <td><?php echo htmlspecialchars($vypisy['idobjednavky']) ?></td>
                                    <td class="d-none d-md-table-cell"><?php echo htmlspecialchars($vypisy['datum']) ?></td>
                                    <td class="d-none d-md-table-cell"><?php echo htmlspecialchars($vypisy['mesto']) ?></td>
                                    <td class="d-none d-md-table-cell"><?php echo htmlspecialchars($vypisy['adresa_cp']) ?></td>
                                    <td class="d-none d-md-table-cell"><?php echo htmlspecialchars($vypisy['psc']) ?></td>
                                    <td class="d-none d-sm-table-cell"><?php echo htmlspecialchars($odeslani) ?></td>
                                    <td> <button class="btn btn-primary my-2 my-sm-0 custom-button" value="<?php echo $vypisy['idobjednavky'] ?>" name="idobjednavky">Zobrazit</button>
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