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
  <h2 class="text-center py-3">Products</h2>

  <?php
    $display_product = mysqli_query($conn, "SELECT * FROM `products`");
    if (mysqli_num_rows($display_product) > 0) {
  ?>

  <div class="table-responsive">
    <table class="table table-bordered table-striped">
      <thead>
        <tr class="table-danger text-center">
          <th>Product Id</th>
          <th>Product Image</th>
          <th>Product Name</th>
          <th>Product Price</th>
          <th>Product Category</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = mysqli_fetch_assoc($display_product)) { ?>
          <tr class="align-middle text-center">
            <td><?php echo $row['id'] ?></td>
            <td>
              <img src="Images/<?php echo $row['image'] ?>" 
                   alt="<?php echo $row['name'] ?>" 
                   class="img-fluid rounded" 
                   style="width: 100px; height: 150px;object-fit:cover;">
            </td>
            <td><?php echo $row['name'] ?></td>
            <td>LKR <?php echo number_format($row['price'], 2) ?></td>
            <td><?php echo $row['category'] ?></td>
            <td>
              <a href="delete.php?delete=<?php echo $row['id'] ?>" >
                <i class="fas fa-trash px-2" style="color:red;" onclick="return confirm('Are you sure you want to delete this product?');"></i>
              </a>
              <a href="update.php?edit=<?php echo $row['id'] ?>" style="color:#088178;">
                <i class="fas fa-edit px-2"></i>
              </a>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>

  <?php
    } else {
      echo "<div class='text-center no-product-text'>No Products Available...!!</div>";
    }
  ?>
</div>

</body>
</html>

<?php
include 'footer.php';
?>
