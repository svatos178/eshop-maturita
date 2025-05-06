<?php

if (!isset($_SESSION['idUzivatel']) || $email !== "admin@email.cz") {
    header("location: index.php");
    return;
}
?>