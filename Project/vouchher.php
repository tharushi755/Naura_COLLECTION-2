<?php
include 'config.php';

if (isset($_POST['place-order'])) {
    $sender_name = mysqli_real_escape_string($conn, $_POST['sender-name']);
    $sender_email = mysqli_real_escape_string($conn, $_POST['sender-email']);
    $receiver_name = mysqli_real_escape_string($conn, $_POST['receiver-name']);
    $receiver_email = mysqli_real_escape_string($conn, $_POST['receiver-email']);
    $payment_method = mysqli_real_escape_string($conn, $_POST['payment-method']);

    $select_vouchers = mysqli_query($conn, "SELECT * FROM `vouchers`");

    if (mysqli_num_rows($select_vouchers) > 0) {
        $order_successful = true;

        while ($voucher_item = mysqli_fetch_assoc($select_vouchers)) {
            $voucher_name = $vouchert_item['name'];
            $voucher_price = $vouchert_item['price'];

            $insert_order_query = "INSERT INTO `orders` 
                (name, email, address, contactNo1, contactNo2, city, product_image, product_name, size, quantity, subtotal, payment_method) 
                VALUES 
                ('$name', '$email', '$address', '$contact_no1', '$contact_no2', '$city', '$product_image', '$product_name', '$product_size', '$product_quantity', '$subtotal', '$payment_method')";

            $insert_order = mysqli_query($conn, $insert_order_query);

            if (!$insert_order) {
                $order_successful = false;
                $display_message = "Failed to place the order: " . mysqli_error($conn);
                break;
            }
        }

        if ($order_successful) {
            $clear_cart_query = "DELETE FROM `cart`";
            $clear_cart = mysqli_query($conn, $clear_cart_query);

            if ($clear_cart) {
                $display_message = "Order placed successfully!";
                header('location:index.php');
            } else {
                $display_message = "Order placed, but failed to clear the cart: " . mysqli_error($conn);
            }
        }
    } else {
        $display_message = "Your cart is empty. Please add items to your cart before placing an order.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>

    <?php
    include 'header.php';
    ?>


    <section id="product1" class="container-fluid sec-padding pb-5">
        <h1>Naura Collection Gift Voucher!</h1>
        <p style="max-width:500px">
            Give the gift of style with Naura Collection Gift Vouchers. Perfect for any occasion, let your loved ones choose their favorite fashion pieces and create unforgettable looks!
            occasion. Redefine your wardrobe with pieces that inspire confidence and celebrate your unique style
        </p>
        <div class="pro-container">
            <?php
            $select_vouchers = mysqli_query($conn, "SELECT * FROM `vouchers`");
            if (mysqli_num_rows($select_vouchers) > 0) {
                while ($fetch_voucher = mysqli_fetch_assoc($select_vouchers)) {
                    $modalId = 'modal_' . $fetch_voucher['id'];
            ?>
                    <form action="" method="post">
                        <div class="pro">
                            <div class="pro-img" data-bs-toggle="modal" data-bs-target="#<?php echo $modalId; ?>">
                                <img src="Images/voucher/<?php echo $fetch_voucher['voucher']; ?>" alt="">
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="<?php echo $modalId; ?>" tabindex="-1" aria-labelledby="modalLabel_<?php echo $fetch_voucher['id']; ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5>
                                                voucher Details
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-6">
                                                    <img src="Images/voucher/<?php echo $fetch_voucher['voucher']; ?>" alt="">
                                                </div>
                                                <div class="col-6">
                                                    <p>voucher Id : <?php echo $fetch_voucher['id']; ?></p>
                                                    <p><?php echo $fetch_voucher['name']; ?></p>
                                                    <p>LKR <?php echo number_format($fetch_voucher['price']); ?>.00</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 col-md-6">
                                                    <input type="text" name="sender-name" class="form-control form-control-lg mt-4" placeholder="Sender Name" style="font-size: 13px;" required>
                                                </div>
                                                <div class="col-sm-12 col-md-6">
                                                    <input type="text" name="sender-email" class="form-control form-control-lg mt-4" placeholder="Sender Email" style="font-size: 13px;" required>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 col-md-6">
                                                    <input type="text" name="receiver-name" class="form-control form-control-lg mt-4" placeholder="Receiver Name" style="font-size: 13px;" required>
                                                </div>
                                                <div class="col-sm-12 col-md-6">
                                                    <input type="text" name="receiver-email" class="form-control form-control-lg mt-4" placeholder="Receiver Email" style="font-size: 13px;" required>
                                                </div>
                                            </div>
                                            <textarea name="Note" class="form-control form-control-lg mt-4" rows="3" placeholder="Note" style="font-size: 13px;" required></textarea>
                                            <h4 class="pt-5">PAYMENT METHOD</h4>
                                            <div class="form-check mt-4 payment-method">
                                                <input type="radio" class="form-check-input" id="radio1" name="payment-method" value="Online Card Payment" checked>
                                                <label class="form-check-label" for="radio1">Online Card Payment</label>
                                            </div>
                                            <div class="form-check mt-4 payment-method">
                                                <input type="radio" class="form-check-input" id="radio2" name="payment-method" value="Cash On Delivery">
                                                <label class="form-check-label" for="radio2">Cash On Delivery</label>
                                            </div>
                                            <div class="form-check mt-4 mb-5 payment-method">
                                                <input type="radio" class="form-check-input" id="radio3" name="payment-method" value="Powered by WebXPay">
                                                <label class="form-check-label">Powered by WebXPay</label>
                                            </div>
                                            <div class="row">
                                                <div class="col-3">
                                                    <input type="number" name="update_qty" min="1" max="3" class="form-control form-control-lg" value="1" style="font-size: 13px;" required>
                                                </div>
                                                <div class="col-9 d-grid">
                                                    <button type="submit" class="btn btn-block checkout-btn" data-bs-dismiss="modal" name="buy-now">Buy Now</button>
                                                </div>
                                            </div>
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
                echo "<div class='no-product-text'>No vouchers Available...!!</div>";
            }
            ?>
        </div>

    </section>

    <?php
    include 'footer.php';
    ?>

</body>

</html>