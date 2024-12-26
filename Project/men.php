<?php
include 'header.php';
include 'config.php';

if (isset($_POST['add_to_cart'])) {
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_size = $_POST['product_size'];
    $product_image = $_POST['product_image'];
    $product_quantity = 1;

    $select_cart = mysqli_query($conn, "SELECT * FROM `cart` where name='$product_name'");
    if (mysqli_num_rows($select_cart) > 0) {
        $display_message = "Products Alreddy added to cart";
    } else {
        $insert_product = mysqli_query($conn, "INSERT INTO `cart`(name,price,image,size,quantity) values ('$product_name','$product_price','$product_image','$product_size','$product_quantity')");
    }
}



if (isset($display_message)) {
    echo "
        <div class='error-msg '>
            <span class='error-contetnt'>.$display_message.</span>
            <i class='fas fa-times' onclick='this.parentElement.style.display=`none`';></i>
        </div>";
}
?>
<section id="product1" class="container-fluid sec-padding pb-0">
    <h1>Discover the Latest Trends in Fashion</h1>
    <p style="max-width:500px">
        Explore our New Arrivals collection, featuring fresh, stylish designs crafted to elevate your wardrobe. From chic casualwear to elegant evening outfits, find the perfect pieces to stay ahead of the fashion curve this season.
    </p>
    <div class="pro-container">
        <?php
        $select_products = mysqli_query($conn, "SELECT * FROM `products` WHERE category = 'men' OR category = 'new arrivals men'");
        if (mysqli_num_rows($select_products) > 0) {
            while ($fetch_product = mysqli_fetch_assoc($select_products)) {
                $modalId = 'modal_' . $fetch_product['id'];
        ?>
                <form action="" method="post">
                    <div class="pro" >
                        <div class="pro-img" data-bs-toggle="modal" data-bs-target="#<?php echo $modalId; ?>">
                            <img src="Images/<?php echo $fetch_product['image']; ?>" alt="">
                        </div>

                        <div class="des">
                            <p class="brand-name">Naura COLLECTION</p>
                            <p><?php echo $fetch_product['name']; ?></p>
                            <h4>LKR <?php echo number_format($fetch_product['price']);?>.00</h4>
                        </div>

                        <!-- Modal -->
                        <div class="modal fade" id="<?php echo $modalId; ?>" tabindex="-1" aria-labelledby="modalLabel_<?php echo $fetch_product['id']; ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5>
                                            Product Details
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-6">
                                                <img src="Images/<?php echo $fetch_product['image']; ?>" alt="">
                                            </div>
                                            <div class="col-6">
                                                <p>Product Id : <?php echo $fetch_product['id']; ?></p>
                                                <p>Product Name : <?php echo $fetch_product['name']; ?></p>
                                                <p>Product Price : LKR <?php echo number_format($fetch_product['price']);?>.00</p>
                                                <p><u>Select Your Size</u></p>
                                                <select class="select-size" id="size" name="product_size">
                                                    <option>XS</option>
                                                    <option>S</option>
                                                    <option>M</option>
                                                    <option>L</option>
                                                    <option>XL</option>
                                                    <option>XXL</option>
                                                    <option>XXXL</option>
                                                </select>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-dark" data-bs-dismiss="modal" name="add_to_cart">Add To Cart</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
                        <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
                        <input type="hidden" name="product_category" value="<?php echo $fetch_product['category']; ?>">
                        <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
                    </div>
                </form>
        <?php
            }
        } else {
            echo "<div class='no-product-text'>No Products Available...!!</div>";
        }
        ?>
    </div>

</section>
<!--men section end-->





<?php
include 'footer.php';
?>