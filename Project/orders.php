<?php
include 'header.php';
include 'config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Products</title>
  <style>
  </style>
</head>
<body>

<div class="container mt-5" style="min-height:100vh;">
  <h2 class="text-center py-3">Orders</h2>

  <?php
    $display_orders = mysqli_query($conn, "SELECT * FROM `orders`");
    if (mysqli_num_rows($display_orders) > 0) {
  ?>

  <div class="table-responsive">
    <table class="table table-bordered table-striped ">
      <thead>
        <tr class="table-danger text-center">
          <th>Order No</th>
          <th>Customer Name</th>
          <th>Email</th>
          <th>Address</th>
          <th>Contact No</th>
          <th>City</th>
          <th>Order Details</th>
          <th>Payment Method</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = mysqli_fetch_assoc($display_orders)) { ?>
          <tr class="align-start text-center">
            <td><p><?php echo $row['id'] ?></p></td>
            <td><p><?php echo $row['name'] ?></p></td>
            <td><p><?php echo $row['email'] ?></p></td>
            <td><p><?php echo $row['address'] ?></p></td>
            <td><p><?php echo $row['contactNo1'] ?>/<?php echo $row['contactNo2'] ?></p></td>
            <td><p><?php echo $row['city'] ?></p></td>
            <td>
            <img src="Images/<?php echo $row['product_image'] ?>" 
                   alt="<?php echo $row['product_name'] ?>" 
                   class="img-fluid rounded" 
                   style="width: 100px; height: 150px;object-fit:cover;">
            <p><?php echo $row['product_name'] ?></p>
            <p><?php echo $row['size'] ?></p>
            <p><?php echo $row['quantity'] ?></p>
            <p><?php echo $row['subtotal'] ?></p>
            </td>
            <td><p><?php echo $row['payment_method'] ?></p></td>
            <td>
              <a href="delete-2.php?delete=<?php echo $row['id'] ?>">
                <i class="fas fa-trash-can px-2" style="color:red;" onclick="return confirm('Are you sure you want to delete this Order?');"></i>
              </a>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>

  <?php
    } else {
      echo "<div class='text-center no-product-text'>No Orders Available...!!</div>";
    }
  ?>
</div>

</body>
</html>

<?php
include 'footer.php';
?>
