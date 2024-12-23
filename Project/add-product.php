<?php
ob_start();
include 'header.php';
include 'config.php';

if (isset($_POST['add_product'])) {
    $product_name = $_POST['add_name'];
    $product_price = $_POST['add_price'];
    $product_category = $_POST['add_category'];
    $product_image = $_FILES['product_image']['name'];
    $product_image_temp_name = $_FILES['product_image']['tmp_name'];
    $product_image_folder = 'Images/' . $product_image;

    $insert_query = mysqli_query($conn, "insert into `products`(name,price,category,image) values('$product_name','$product_price','$product_category','$product_image')") or die("Insert query failed");
    if ($insert_query) {
        move_uploaded_file($product_image_temp_name, $product_image_folder);
        header('location:view_products.php');
        ob_end_flush();
    } else {
        $display_message = "There is some error in inserting the product";
    }
}
?>

<div class="container d-flex justify-content-center align-items-center" style="min-height:100vh">


    <div class="row login-form bg-light shadow rounded">
        <div class="col-sm-12 col-md-6 d-none d-md-block px-0">
            <img class="img-fluid" src="Images/footer/5.jpg" alt="">
        </div>
        <div class="col-sm-12 col-md-6">
            <form method="post" class="mx-5 log-form" enctype="multipart/form-data">
                <h3>Add Product</h3>
                <?php
                if (isset($display_message)) {
                    echo "
                    <div class='error-msg '>
                        <span class='error-contetnt'>.$display_message.</span>
                        <i class='fas fa-times' onclick='this.parentElement.style.display=`none`';></i>
                    </div>";
                }
                ?>
                <div class="px-0 pt-4">
                    <input class="form-control" type="text" name="add_name" placeholder="Enter product name" required>
                </div>
                <div class="px-0 pt-4">
                    <input class="form-control" type="number" name="add_price" placeholder="Enter Product Price"
                        required>
                </div>
                <div class="px-0 pt-4">
                    <p>Category</p>
                    <select class="form-select" id="sel1" name="add_category">
                        <option>Women</option>
                        <option>Men</option>
                        <option>Kids</option>
                        <option>New arrivals Men</option>
                        <option>New arrivals Women</option>
                        <option>New arrivals kids</option>
                    </select>
                </div>
                <div class="px-0 pt-4">
                    <input class="form-control" type="file" name="product_image" required
                        accept="image/png,image/jpg,image/jpeg">
                </div>
                <div class="d-grid">
                    <input type="submit" name="add_product" value="Add Product" class="btn sub-btn btn-block mt-4">
                </div>
            </form>
        </div>
    </div>
</div>

<?php
include 'footer.php';
?>