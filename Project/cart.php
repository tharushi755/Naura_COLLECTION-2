<?php
include 'config.php';

if (isset($_POST['update_product_qty'])) {
  $update_value = $_POST['update_qty'];
  $update_id = $_POST['update_qty_id'];

  $update_qty_query = mysqli_query($conn, "UPDATE `cart` SET quantity= $update_value where id= $update_id");
  if ($update_qty_query) {
    header('Location:index.php?cart=open');
    exit;
  }
}

if (isset($_GET['delete'])) {
  $delete_id = $_GET['delete'];
  $delete_query = mysqli_query($conn, "DELETE FROM `cart` WHERE id= $delete_id");

  if ($delete_query) {
    header('Location: index.php?cart=open');
    exit;
  }
}


$select_product = mysqli_query($conn, "SELECT * FROM `cart`") or die('Query failed');
$row_count = mysqli_num_rows($select_product);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>


  <div class="offcanvas offcanvas-end" tabindex="-1" id="sideCart" aria-labelledby="sideCartLabel" style="width: 100%; max-width: 500px;">
    <div class="offcanvas-header">
      <h6 class="offcanvas-title text-center" id="sideCartLabel">Cart</h6>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <p class="px-3"><?php echo $row_count ?> products are in your cart</p>
    <div class="offcanvas-body d-flex flex-column">

      <?php
      $select_cart_products = mysqli_query($conn, "SELECT * FROM `cart`");
      $net_total = 0;
      if (mysqli_num_rows($select_cart_products) > 0) {
        while ($fetch_assoc_products = mysqli_fetch_assoc($select_cart_products)) {
      ?>


          <div class="row mb-5">
            <div class="col-4">
              <img src="Images/<?php echo $fetch_assoc_products['image'] ?>" alt="" class="img-fluid rounded" style="width: 100px; max-height: 130px; object-fit: cover;">
            </div>
            <div class="col-8">
              <p class="mb-1"><?php echo $fetch_assoc_products['name'] ?></p>
              <p class="mb-1">LKR <?php echo $subtotal = number_format($fetch_assoc_products['price']) ?>.00</p>
              <p class="mb-3">Size - <?php echo $fetch_assoc_products['size'] ?></p>
              <div class="d-flex align-items-center">
                <form action="" method="post">
                  <input type="hidden" value="<?php echo $fetch_assoc_products['id'] ?>" name="update_qty_id">
                  <input type="number" min="1" max="3" name="update_qty" value="<?php echo $fetch_assoc_products['quantity'] ?>" style="width: 50px; border: none; background-color: black; color: white; text-align: center;">
                  <button type="submit" name="update_product_qty" data-bs-target="#sideCart" aria-controls="sideCart" style="border: none; margin-left: 10px;"><i class="fas fa-check" style="color: #088178; font-size: 18px; font-weight: 900; background-color:white;"></i></button>
                </form>
              </div>
              <div class="d-flex justify-content-between align-items-center mt-3">
                <p class="mb-0">Total Amount: LKR <?php echo $subtotal = number_format($fetch_assoc_products['price'] * $fetch_assoc_products['quantity']) ?></p>
                <a href="index.php?delete=<?php echo $fetch_assoc_products['id']; ?>"
                  onclick="return confirm('Are you sure you want to delete this product?');">
                  <i class="fas fa-trash-can" style="font-size: 18px; cursor: pointer; color:red;"></i>
                </a>

              </div>
            </div>
          </div>
      <?php

          $net_total = $net_total + ($fetch_assoc_products['price'] * $fetch_assoc_products['quantity']);
        }
      } else {
        echo "No Product";
      }
      ?>


      <div class="mt-auto">
        <div class="row">
          <div class="col-6">
            <p class="mb-1">Gross Total:</p>
            <p class="mb-1">Discount:</p>
            <p class="mb-1">Net Total:</p>
          </div>
          <div class="col-6 d-flex flex-column align-items-end">
            <p class="mb-1">LKR <?php echo number_format($net_total) ?>.00</p>
            <p class="mb-1">LKR 0.00</p>
            <p class="mb-1">LKR <?php echo number_format($net_total) ?>.00</p>
          </div>
        </div>
        <a href="checkout.php"><button class="btn checkout-btn w-100 mt-3">Checkout</button></a>
      </div>
    </div>
  </div>

  <?php if (isset($_GET['cart']) && $_GET['cart'] === 'open'): ?>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
        var cartOffcanvas = new bootstrap.Offcanvas(document.getElementById('sideCart'));
        cartOffcanvas.show();
      });
    </script>
  <?php endif; ?>

</body>

</html>