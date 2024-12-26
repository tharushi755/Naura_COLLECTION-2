<?php
include 'config.php';

if (isset($_POST['place-order'])) {
    $first_name = mysqli_real_escape_string($conn, $_POST['Fname']);
    $last_name = mysqli_real_escape_string($conn, $_POST['Lname']);
    $name = $first_name . ' ' . $last_name;
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $contact_no1 = mysqli_real_escape_string($conn, $_POST['contactN1']);
    $contact_no2 = mysqli_real_escape_string($conn, $_POST['contactN2']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $payment_method = mysqli_real_escape_string($conn, $_POST['payment-method']);

    $select_cart_products = mysqli_query($conn, "SELECT * FROM `cart`");
    $net_total = 0;

    if (mysqli_num_rows($select_cart_products) > 0) {
        $order_successful = true;

        while ($cart_item = mysqli_fetch_assoc($select_cart_products)) {
            $product_image = $cart_item['image'];
            $product_name = $cart_item['name'];
            $product_size = $cart_item['size'];
            $product_quantity = $cart_item['quantity'];
            $product_price = $cart_item['price'];
            $subtotal = $product_price * $product_quantity;
            $net_total += $subtotal;

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
    <title>Naura COLLECTION</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
</head>

<body>
    <div class="container-fluid sec-padding">
        <div class="row">
            <div class="col-sm-12 col-md-6 px-5">
                <h3>Naura COLLECTION</h3>
                <hr>
                <?php
                if (isset($display_message)) {
                    echo "
                    <div class='error-msg '>
                        <span class='error-contetnt'>.$display_message.</span>
                        <i class='fas fa-times' onclick='this.parentElement.style.display=`none`';></i>
                    </div>";
                }
                ?>
                <form method="post">
                    <h4 class="pt-5">CONTACT</h4>
                    <input type="email" name="email" class="form-control form-control-lg mt-3" placeholder="Email" style="font-size: 13px;" required>
                    <h4 class="pt-5">DELIVERY</h4>
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <input type="text" name="Fname" class="form-control form-control-lg mt-4" placeholder="First Name" style="font-size: 13px;" required>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <input type="text" name="Lname" class="form-control form-control-lg mt-4" placeholder="Last Name" style="font-size: 13px;" required>
                        </div>
                    </div>
                    <input type="text" name="address" class="form-control form-control-lg mt-4" placeholder="Address" style="font-size: 13px;" required>
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <input type="number" name="contactN1" class="form-control form-control-lg mt-4" placeholder="Contact No 1" style="font-size: 13px;" required>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <input type="number" name="contactN2" class="form-control form-control-lg mt-4" placeholder="Contact No 2" style="font-size: 13px;" required>
                        </div>
                    </div>
                    <input type="text" name="city" class="form-control form-control-lg mt-4" placeholder="Your City" style="font-size: 13px;" required>
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

            </div>
            <div class="col-sm-12 col-md-6 px-5">
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
                                <p class="mb-1">Size - <?php echo $fetch_assoc_products['size'] ?></p>
                                <p class="mb-1">Quantity - <?php echo $fetch_assoc_products['quantity'] ?></p>
                                <p class="mb-0">Total Amount: LKR <?php echo $subtotal = number_format($fetch_assoc_products['price'] * $fetch_assoc_products['quantity']) ?>.00</p>

                            </div>
                        </div>
                <?php

                        $net_total = $net_total + ($fetch_assoc_products['price'] * $fetch_assoc_products['quantity']);
                    }
                } else {
                    echo "No Product";
                }
                ?>

                <div class="row py-5">
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




            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-6 px-5">
                <button name="place-order" type="submit" class="btn checkout-btn w-100 mb-5">Place Order</button>
            </div>
        </div>

    </div>

    </form>
</body>

</html>