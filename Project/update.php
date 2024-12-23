<?php
ob_start();
include 'header.php';
include 'config.php';

if (isset($_POST['update_product'])) {
    $update_id = $_POST['update-id'];
    $update_name = $_POST['update-name'];
    $update_price = $_POST['update-price'];
    $update_category = $_POST['update_category'];
    $update_image = $_FILES['update-image']['name'];
    $update_image_temp_name = $_FILES['update-image']['tmp_name'];
    $update_image_folder = 'Images/' . $update_image;

    $update_product = mysqli_query($conn, "UPDATE `products` SET 
        name='$update_name',price='$update_price',category='$update_category',image='$update_image'
        WHERE id=$update_id");


    if ($update_product) {
        move_uploaded_file($update_image_temp_name, $update_image_folder);
        header('location:view_products.php');
        ob_end_flush();
    } else {
        $display_message = "There is error in updating the product detailes";
    }
}
?>

<div class="container d-flex justify-content-center align-items-center" style="min-height:100vh;">
    <div class="row login-form bg-light shadow rounded pb-5">
        <div class="col-sm-12 col-md-6 d-none d-md-block px-0">
            <img class="img-fluid" src="Images/footer/5.jpg" alt="">
        </div>
        <div class="col-sm-12 col-md-6">
            <?php
            if (isset($_GET['edit'])) {
                $edit_id = $_GET['edit'];
                //echo $edit_id;
                $edit_query = mysqli_query($conn, "SELECT * FROM `products` WHERE id=$edit_id");
                if (mysqli_num_rows($edit_query) > 0) {
                    while ($fetch_data = mysqli_fetch_assoc($edit_query)) {
                        // $row=$fetch_data['price'];
                        // echo $row;

            ?>
                        <form method="post" class="mx-5 log-form" enctype="multipart/form-data">
                            <?php
                            if (isset($display_message)) {
                                echo "
                                    <div class='error-msg ' style='margin-bottom:30px;'>
                                        <span class='error-contetnt'>.$display_message.</span>
                                        <i class='fas fa-times' onclick='this.parentElement.style.display=`none`';></i>
                                    </div>";
                            }
                            ?>
                            <img src="Images/<?php echo $fetch_data['image'] ?>" alt="" style="width:150px; height:200px;">
                            <div class="px-0 pt-4">
                                <input class="form-control" type="hidden" value="<?php echo $fetch_data['id'] ?>" name="update-id">
                            </div>
                            <div class="px-0 pt-4">
                                <input class="form-control" type="text" required value="<?php echo $fetch_data['name'] ?>" name="update-name">
                            </div>
                            <div class="px-0 pt-4">
                                <input class="form-control" type="number" required value="<?php echo $fetch_data['price'] ?>" name="update-price">
                            </div>
                            <div class="px-0 pt-4">
                                <p>Category</p>
                                <select class="form-select" id="sel1" name="update_category">
                                    <option>Women</option>
                                    <option>Men</option>
                                    <option>Kids</option>
                                    <option>New arrivals Men</option>
                                    <option>New arrivals Women</option>
                                    <option>New arrivals kids</option>
                                </select>
                            </div>
                            <div class="px-0 pt-4">
                                <input class="form-control" type="file"
                                    accept="image/png,image/jpg,image/jpeg" name="update-image">
                            </div>
                            <div class="row mb-4">
                                <div class="col-6">
                                    <div class="d-grid">
                                        <input type="submit" name="update_product" value="Update Product" class="btn sub-btn btn-block mt-4">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="d-grid">
                                        <input type="reset" value="Cancel" class="btn sub-btn btn-block mt-4">
                                    </div>
                                </div>
                            </div>
                        </form>
            <?php
                    }
                }
            }
            ?>
        </div>
    </div>
</div>

<?php
include 'footer.php';
?>