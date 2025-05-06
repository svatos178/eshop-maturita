<?php
include("head.php");
include('server.php');
include("navbar.php");

?>

<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">


  <link rel="canonical" href="https://getbootstrap.com/docs/4.5/examples/checkout/">


  <link href="../assets/dist/css/bootstrap.min.css" rel="stylesheet">


  <style>
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }
  </style>
  <link href="form-validation.css" rel="stylesheet">
</head>

<body>


  <main class="main popis-vrsek">


    <div class="container">


      <div class="row">
        <div class="col-md-6 order-md-2 mb-4">
          <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-muted">Váš košík</span>
            <span class="badge badge-secondary badge-pill"><?php  ?></span>
          </h4>
          <ul class="list-group mb-3">
            <?php $kosik_pole = kosik($db);
            $celkem = 0;
            for ($i = 0; $i < count($kosik_pole); $i++) {
              $value = $kosik_pole[$i];
              $idKosik = $kosik_pole[$i]["idKosik"];
            ?>

              <li class="list-group-item d-flex justify-content-between lh-condensed velikost-top"  id="<?= $kosik_pole[$i]["idKosik"] ?>">
                <div>
                  <h4 class="my-0 kosik-jmeno div-button"> <?php echo $kosik_pole[$i]["jmenoProdukt"]; ?> </h4>

                  
                    <div class="popis-vrsek">
                      <small class="text-muted">velikost:</small>
                      <select name="zmenaVelikosti" id="velikosti" style="width:44px" zmenitVelikost="<?= $kosik_pole[$i]["idKosik"] ?>">
                        <?php
                        $velikosti = ["xs", "s", "m", "l", "xl", "xxl"];
                     
                        ?>
                        <?php
                        foreach ($velikosti as $velikost) {
                        ?>
                          <option value="<?= $velikost ?>" <?= $velikost == $kosik_pole[$i]["velikost"] ? "selected" : "" ?>><?= $velikost ?></option>
                        <?php
                        }
                        ?>
                      </select>
                      <input type="hidden" value="<?php echo $kosik_pole[$i]["idKosik"]; ?>" name="idKosik">
                      </br>
                    </div>
                    <div class="mt-2">
                      <small class="text-muted">počet: <input type="number" value="<?= $kosik_pole[$i]["pocet"]
                       ?>" min="1" name="zmenaPocet" style="width:56px" zmenitPocet="<?= $kosik_pole[$i]["idKosik"] ?>"></small>
                      <input type="hidden" value="<?php echo $kosik_pole[$i]["idKosik"]; ?>" name="idKosik">


                    </div>

                </div>
                <div class="cena-top">
                  <span class="text-muted"><?php echo number_format((int) $kosik_pole[$i]["cenaProdukt"], 2, '.', ' '); ?>&nbsp;Kč
                    </br>
                    <button type="submit" name="smazatKosik" smazatKosik="<?php echo $kosik_pole[$i]["idKosik"]; ?>" class="btn btn-primary custom-button down">smazat</button>

                  </span>
                </div>
              
              </li>

            <?php
              $celkem += ((int) $kosik_pole[$i]["cenaProdukt"]) * ((int) $kosik_pole[$i]["pocet"]);
            }
            ?>

            <li class="list-group-item d-flex justify-content-between">
              <span id="celkovaCena">Celkem: <?php echo number_format((int)$celkem, 2, '.', ' '); ?>&nbsp;Kč</span>
              <strong></strong>
            </li>
          </ul>


        </div>
        <div class="col-md-6 order-md-1">
          <h4 class="mb-3 text-muted">Údaje k objednání</h4>
          <form class="needs-validation spodek"  action="" method="post" class="m-2">
            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="firstName">Jméno</label>
                <input type="text" class="form-control" id="firstName" value="<?= $uzivatel['jmeno'] ?>" readonly="readonly">

              </div>
              <div class="col-md-6 mb-3">
                <label for="lastName">Příjmení</label>
                <input type="text" class="form-control" id="lastName" value="<?= $uzivatel['prijmeni'] ?>" readonly="readonly">

              </div>
            </div>


            <div class="mb-3">
              <label for="email">Email</label>
              <input type="email" class="form-control" id="email" readonly="readonly" value="<?= $uzivatel['email'] ?>">
            </div>

            <div class="mb-3">
              <label for="address">Město</label>
              <input type="text" class="form-control" id="mesto" name="mesto" required> </input>

            </div>

            <div class="mb-3">
              <label for="address">Adresa a číslo popisné</label>
              <input type="text" class="form-control" id="adres_cp" name="adres_cp" required> </input>

            </div>




            <div class=" mb-3">
              <label for="zip">PSČ</label>
              <input type="number" class="form-control" id="psc" name="psc" required min="1"> </input>
            </div>


            <button class="btn btn-primary btn-lg btn-block" type="submit" name="objednat">objednat</button>
          </form>
        </div>
      </div>


    </div>

  </main>

  <?php
  include("footer.php");
  ?>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script>
    window.jQuery || document.write('<script src="../assets/js/vendor/jquery.slim.min.js"><\/script>')

    $('[zmenitVelikost]').change(zmenitVelikost)

    function zmenitVelikost(e) {
      var idKosik = e.target.attributes.getNamedItem("zmenitVelikost").value;
      var optionSelected = $("option:selected", this);
      var velikost = this.value;
      $.get("zmenitVelikost.php", {
        idKosik,
        velikost
      })
    }

    $('[zmenitPocet]').change(zmenitPocet)

    function zmenitPocet(e) {
      var idKosik = e.target.attributes.getNamedItem("zmenitPocet").value;
      var pocet = $(e.target).val();
      $.get("zmenitPocet.php", {
        idKosik,
        pocet
      }).done( function (data) {
    document.querySelector("#celkovaCena").innerHTML = "Celkem: " + data + "Kč.";
  })
    }

  $('[smazatKosik]').click(smazatKosik)

function smazatKosik(e) {
  var idKosik = e.target.attributes.getNamedItem("smazatKosik").value;
  $.get("smazatkosik.php", {
    idKosik
  }).done( function (data) {
    document.querySelector("#celkovaCena").innerHTML = "Celkem: " + data + "Kč.";
    $("#"+idKosik).remove()
  })
}
  </script>
  <script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
  <script src="form-validation.js"></script>

</body>

</html>