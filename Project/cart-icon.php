<?php
include 'config.php';
include 'cart.php';
?>
<style>
    .cart-button {
        position: fixed;
        bottom: 40px;
        right: 40px;
        background-color: black;
        color: white;
        border: none;
        border-radius: 50%;
        padding: 20px 15px;
        font-size: 16px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        cursor: pointer;
        text-decoration: none;
        text-align: center;
        z-index: 1000;
    }

    .user-button {
        position: fixed;
        bottom: 110px;
        right: 40px;
        background-color: black;
        color: white;
        border: none;
        border-radius: 50%;
        padding: 20px 20px;
        font-size: 18px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        cursor: pointer;
        text-decoration: none;
        text-align: center;
        z-index: 1000;
    }


</style>
</head>

<body>
    <div>
        <a href="login_form.php">
            <i class="fas fa-user user-button"></i>
        </a>
        <a id="cart" data-bs-toggle="offcanvas" data-bs-target="#sideCart" aria-controls="sideCart">
            <i class="fas fa-shopping-cart cart-button"><sup style="color:white;"><?php echo $row_count ?></i>
        </a>

        <?php $select_cart = mysqli_query($conn, "SELECT * FROM `cart`") or die('Query failed');
        $row_count = mysqli_num_rows($select_cart);
        if (isset($_GET['cart']) && $_GET['cart'] === 'open'): ?>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    var cartOffcanvas = new bootstrap.Offcanvas(document.getElementById('sideCart'));
                    cartOffcanvas.show();
                });
            </script>
        <?php endif; ?>
</body>

</html>