<?php
include("head.php");
include("server.php");
include("navbar.php");
include_once("kontrola_admin.php");
?>

<body>
    <main class="main">

        <?php

        $uzivatele = mysqli_query($db, "SELECT idUzivatel,jmeno,prijmeni,email,heslo from uzivatel");
        ?>
        
        <div class="container popis-top">
        <table>
            <thead">
                <tr>
                    <th>ID </th>
                    <th class="d-none d-sm-table-cell">jméno </th>
                    <th class="d-none d-sm-table-cell">příjmení </th>
                    <th>email </th>
                    <th>upravit</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($uzivatele as $vypis) : ?>
                    <tr>
                        <td><?php echo $vypis['idUzivatel'] ?></td>
                        <td class="d-none d-sm-table-cell"><?php echo htmlspecialchars($vypis['jmeno']) ?></td>
                        <td class="d-none d-sm-table-cell"><?php echo htmlspecialchars($vypis['prijmeni']) ?></td>
                        <td><?php echo htmlspecialchars($vypis['email']) ?></td>
                        <td><button class="btn btn-primary my-2 my-sm-0" idUzivatel="<?php echo $vypis['idUzivatel'] ?>">Upravit</button></td>
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

$("button[idUzivatel]").click((e) => {
    window.location.href = "upravit_uzivatele.php?id=" + e.target.attributes.getNamedItem("idUzivatel").value;
})
    
</script>