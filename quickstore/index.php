<?php
include("head.php");
include("server.php");
include("navbar.php");
?>

<main class="main">
  <div class="mainbanner flex-between">
    <div class="bannertext">
      <h2 style="font-size:50px">quickstore</h2>
      <div class="bannertext2">
        <h2 style="font-size:40px">online obchod pro snadné nakupování</h2>
      </div>
    </div>
    <img class="bannerimg " src="<?php echo import_file("pozadi.png") ?>">
  </div> <div class="doporucujeme text-uppercase ">
    <h3 style="margin:auto">Doporučujeme</h3>
  </div>
  <?php if (isset($_SESSION['prihlasen'])) : ?>
  <div class="text-success" style="padding-left: 1%;">
        <h3>
          <?php
          echo $_SESSION['prihlasen'];
          unset($_SESSION['prihlasen']);
           ?>
        </h3>
      </div>
    <?php endif ?>
  
    <div class="row" style="padding-top: 2%">
<?php
    $arr_produkt = doporucujemeProdukt();
    

    for ($i = 0; $i < count($arr_produkt); $i++) {
      $value = $arr_produkt[$i];
    ?>
      <div class="col-md-4 col-lg-3 d-flex pb-3" >
        <div class="card mb-4 lg-3 w-100">
          <form action="" method="post">
         <a href="produkt.php?id=<?php echo($value['idProdukt']) ?>">
          <img id="imgprodukt" src="<?php echo import_file($value['imageProdukt']); ?>" alt="" srcset="" class="card-img-top card-img-sizing">
        </a>
            <div class="card-body ">
              <p class="card-text ">
              <a href="produkt.php?id=<?php echo($value['idProdukt']) ?>">  
               <h2 class="nazev-produkt"><?php echo $value['jmenoProdukt']; ?></h2>
              </a>
            <?php  if (isset($_SESSION['idUzivatel']) && $email === "admin@email.cz") {
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
               <h5 class="text-danger cena-polozky"><?php echo $value['cenaProdukt']; ?>,-</h5>   
                </p>
              </div>
            </form>
          </div>
        </div>
      <?php }
      ?>
   </div>



</main>


<?php
include("footer.php");
?>
</body>

</html>