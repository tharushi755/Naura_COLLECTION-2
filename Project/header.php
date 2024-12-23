<?php
include 'config.php';
include 'cart.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Naura COLLECTION</title>
  <link rel="icon" type="image/x-icon" href="Images/icon.png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="style-md.css">
  <link rel="stylesheet" href="style-sm.css">
  <link rel="stylesheet" href="style-lg.css">
  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Archivo:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

  <style>
/* customizable snowflake styling */
.snowflake {
  color: #fff;
  font-size: 1em;
  font-family: Arial, sans-serif;
  text-shadow: 0 0 5px #000;
}

.snowflake,.snowflake .inner{animation-iteration-count:infinite;animation-play-state:running}@keyframes snowflakes-fall{0%{transform:translateY(0)}100%{transform:translateY(110vh)}}@keyframes snowflakes-shake{0%,100%{transform:translateX(0)}50%{transform:translateX(80px)}}.snowflake{position:fixed;top:-10%;z-index:9999;-webkit-user-select:none;user-select:none;cursor:default;animation-name:snowflakes-shake;animation-duration:3s;animation-timing-function:ease-in-out}.snowflake .inner{animation-duration:10s;animation-name:snowflakes-fall;animation-timing-function:linear}.snowflake:nth-of-type(0){left:1%;animation-delay:0s}.snowflake:nth-of-type(0) .inner{animation-delay:0s}.snowflake:first-of-type{left:10%;animation-delay:1s}.snowflake:first-of-type .inner,.snowflake:nth-of-type(8) .inner{animation-delay:1s}.snowflake:nth-of-type(2){left:20%;animation-delay:.5s}.snowflake:nth-of-type(2) .inner,.snowflake:nth-of-type(6) .inner{animation-delay:6s}.snowflake:nth-of-type(3){left:30%;animation-delay:2s}.snowflake:nth-of-type(11) .inner,.snowflake:nth-of-type(3) .inner{animation-delay:4s}.snowflake:nth-of-type(4){left:40%;animation-delay:2s}.snowflake:nth-of-type(10) .inner,.snowflake:nth-of-type(4) .inner{animation-delay:2s}.snowflake:nth-of-type(5){left:50%;animation-delay:3s}.snowflake:nth-of-type(5) .inner{animation-delay:8s}.snowflake:nth-of-type(6){left:60%;animation-delay:2s}.snowflake:nth-of-type(7){left:70%;animation-delay:1s}.snowflake:nth-of-type(7) .inner{animation-delay:2.5s}.snowflake:nth-of-type(8){left:80%;animation-delay:0s}.snowflake:nth-of-type(9){left:90%;animation-delay:1.5s}.snowflake:nth-of-type(9) .inner{animation-delay:3s}.snowflake:nth-of-type(10){left:25%;animation-delay:0s}.snowflake:nth-of-type(11){left:65%;animation-delay:2.5s}
</style>
<div class="snowflakes" aria-hidden="true">
  <div class="snowflake">
    <div class="inner">❅</div>
  </div>
  <div class="snowflake">
    <div class="inner">❅</div>
  </div>
  <div class="snowflake">
    <div class="inner">❅</div>
  </div>
  <div class="snowflake">
    <div class="inner">❅</div>
  </div>
  <div class="snowflake">
    <div class="inner">❅</div>
  </div>
  <div class="snowflake">
    <div class="inner">❅</div>
  </div>
  <div class="snowflake">
    <div class="inner">❅</div>
  </div>
  <div class="snowflake">
    <div class="inner">❅</div>
  </div>
  <div class="snowflake">
    <div class="inner">❅</div>
  </div>
  <div class="snowflake">
    <div class="inner">❅</div>
  </div>
  <div class="snowflake">
    <div class="inner">❅</div>
  </div>
  <div class="snowflake">
    <div class="inner">❅</div>
  </div>
</div>

</head>

<body>


  <!-- Navigation Bar Start -->
  <nav class="navbar navbar-expand-lg sticky-top shadow-sm py-3" style="background:white;">
    <div class="container-fluid">
      <a href="index.php" class="navbar-brand d-flex align-items-center">
        <span class="fw-normal" style="font-size:25px;">Naura</span>
        <span class="text-uppercase fw-bold ms-2" style="font-size:25px;"> Collection</span>
      </a>

      <button class="d-lg-none mt-2 mx-3 navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar" aria-expanded="true">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav mx-auto mt-3 mt-lg-0">
          <li class="nav-item"><a href="new-arrivals.php" class="nav-link px-3">New Arrivals</a></li>
          <li class="nav-item"><a href="Women.php" class="nav-link px-3">Women</a></li>
          <li class="nav-item"><a href="men.php" class="nav-link px-3">Men</a></li>
          <li class="nav-item"><a href="kids.php" class="nav-link px-3">Kids</a></li>
          <li class="nav-item"><a href="vouchher.php" class="nav-link px-3">Gift Vouchers</a></li>
          <li class="nav-item"><a href="about_us.php" class="nav-link px-3">About Us</a></li>
        </ul>
        <?php
        $select_product = mysqli_query($conn, "SELECT * FROM `cart`") or die('Query failed');
        $row_count = mysqli_num_rows($select_product);
        ?>
        <div class="d-flex justify-content-end align-items-center m-3">
          <a href="#" class="d-inline-flex align-items-center text-dark me-3" id="cart" data-bs-toggle="offcanvas" data-bs-target="#sideCart" aria-controls="sideCart">
            <i class="fas fa-shopping-cart"></i>
            <span class="ms-1"><sup><?php echo $row_count; ?></sup></span>
          </a>

          <?php if (isset($_GET['cart']) && $_GET['cart'] === 'open'): ?>
            <script>
              document.addEventListener('DOMContentLoaded', function() {
                var cartOffcanvas = new bootstrap.Offcanvas(document.getElementById('sideCart'));
                cartOffcanvas.show();
              });
            </script>
          <?php endif; ?>
          <a href="login_form.php" class="d-inline-flex align-items-center text-dark">
            <i class="fas fa-user"></i>
          </a>
        </div>
      </div>
    </div>
  </nav>

  <!-- Bootstrap JS -->
</body>

</html>