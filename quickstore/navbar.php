<header id="header" class="text-uppercase">

  <nav class="navbar navbar-expand-xl navbar-light flex-between">
    <a class="logo" href="index.php">quickstore</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
     aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav m-auto">
       <li class="nav-item ">
          <a class="nav-link text-truncate" href="index.php">Domů</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-truncate" href="eshop.php">eshop</a>
        </li>
        
        </li>
        <li class="nav-item">
          <a class="nav-link text-truncate" href="info.php">o nás</a>
        </li>
        <?php if (isset($_SESSION['idUzivatel']) && $uzivatel['email'] === "admin@email.cz") : ?>
          <li class="nav-item">
            <a class="nav-link text-truncate" href="rizeni.php">uživatelé</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-truncate" href="produkty_uprava.php">produkty</a>
          </li>
          <li class="nav-item">
            <a class="nav-link text-truncate" href="objednavky.php">objednávky</a>
          </li>
        <?php endif ?>
      </ul>
      <?php if (!isset($isEshopPage)) : ?>
        <form class="form-inline my-2 my-lg-0" method="get" action="eshop.php">
          <input class="form-control mr-sm-2" type="search" placeholder="vyhledávání" aria-label="Search" name="hledat">
          <button class="btn btn-primary my-2 my-sm-0" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
        </form>
      <?php endif ?>





      <?php if (isset($_SESSION['idUzivatel'])) : ?>

        <form action="#">
          <a href="user.php">
            <span class="nav-link">
              <i class="fa fa-user" aria-hidden="true"></i>
            </span>
          </a>
        </form>

  

        <form action="#">
          <a href="kosik.php">
            <span class="nav-link">
              <i class="fa fa-shopping-cart" aria-hidden="true"></i>
            </span>
          </a>
        </form>

        <form action="#">
          <a href="logout.php">
            <span class="nav-link">

              <i class="fa fa-sign-out" aria-hidden="true"></i>
            </span>
          </a>
        </form>
      <?php else : ?>
    
  
    
    
    

    <form action="#">
      <a href="login.php">
        <span class="nav-link">
          <i class="fa fa-sign-in" aria-hidden="true"></i>
        </span>
      </a>
    </form>
  <?php endif ?>



</div>
  </div>
  </nav>


</header>