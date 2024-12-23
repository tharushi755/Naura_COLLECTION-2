<?php
include 'header.php';
?>

<div class="container d-flex justify-content-center align-items-center" style="min-height:100vh; max-width:900px">
    <div class="row login-form bg-light shadow rounded">
        <div class="col-sm-12 col-md-6 d-none d-md-block px-0">
            <img class="img-fluid" src="Images/footer/5.jpg" alt="">
        </div>
        <div class="col-sm-12 col-md-6">
            <form method="POST" class="mx-5 log-form">
                <h3 class="pb-4">Welcome </h3>
                <p style="text-align:center; max-width:500px !important;"> Manage your product catalog with ease! Use the Add Product button to upload new items to your collection, and the View Product Table button to review, edit, or organize your existing listings efficiently.</p>
                <div class="d-grid">
                    <a id="textchange" href="add-product.php" type="button" class="btn sub-btn btn-block mt-4">Add Product</a>
                </div>
                <div class="d-grid">
                    <a id="textchange" href="view_products.php" type="button" class="btn sub-btn btn-block mt-4">View Products</a>
                </div>
                <?php
                $select_orders = mysqli_query($conn, "SELECT * FROM `orders`") or die('Query failed');
                $row_count = mysqli_num_rows($select_orders);
                ?>
                <div class="d-grid">
                    <a id="textchange" href="orders.php" type="button" class="btn sub-btn btn-block mt-4">View Orders <span style="background-color: black; color:white; margin:4px; padding:3px 5px;"><?php echo $row_count; ?></span> </a>
                </div>
            </form>
        </div>
    </div>
</div>


<?php
include 'footer.php';
?>
</body>

</html>