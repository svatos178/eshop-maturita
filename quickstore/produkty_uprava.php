<?php
include("head.php");
include("server.php");
include("navbar.php");
include_once("kontrola_admin.php");



?>

<body>
    <main class="main">
        <?php include("success_message.php"); 
        $produkt = mysqli_query($db, "SELECT * from produkt");



        
        ?>

        <div class="container popis-top">
            <tbody>

                <tr>
                    <td> <a href="produkt_pridani.php"><button class="btn btn-primary my-2 my-sm-0">Přidat produkt</button></a></td>
                    
                </tr>

            </tbody>
            </table>
        </div>

        <div class="container spodek">
            <table>
                <thead">
                    <tr>
                        <th>ID </th>
                        <th>jméno produktu </th>
                        <th class="d-none d-sm-table-cell">Kategorie </th>
                        <th class="d-none d-sm-table-cell">Značka </th>
                        <th>Upravit</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($produkt as $vypis) : ?>
                            <tr>
                                <td><?php echo $vypis['idProdukt'] ?></td>
                                <td><?php echo htmlspecialchars($vypis['jmenoProdukt']) ?></td>
                                <td class="d-none d-sm-table-cell"><?php echo htmlspecialchars($vypis['kategorieProdukt']) ?></td>
                                <td class="d-none d-sm-table-cell"><?php echo htmlspecialchars($vypis['znackaProdukt']) ?></td>
                                <td><button class="btn btn-primary my-2 my-sm-0" idProdukt="<?php echo $vypis['idProdukt'] ?>">Upravit</button></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
            </table>
        </div>
    </main>

    <?php
    include("footer.php");
    ?>
</body>

<script>
    $("button[idProdukt]").click((e) => {
        window.location.href = "produkt_prepsani.php?id=" + e.target.attributes.getNamedItem("idProdukt").value;
    })
</script>