<?php
ob_start();
session_start();
include 'header.php'; 
include 'config.php'; 

$error = []; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $email = mysqli_real_escape_string($conn, $_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    
    if (empty($email) || empty($password)) {
        $error[] = 'Email and Password are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error[] = 'Invalid email format.';
    } else {
        
        $query = "SELECT * FROM user_form WHERE email = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) === 1) {
            $user = mysqli_fetch_assoc($result);
            if (password_verify($password, $user['password'])) {
               
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_type'] = $user['user_type'];

                
                if ($user['user_type'] === 'admin') {
                    header('Location: add-view-product.php'); 
                    ob_end_flush();
                } elseif ($user['user_type'] === 'user') {
                    header('Location: index.php');
                }
                exit(); 
            } else {
                $error[] = 'Incorrect password.';
            }
        } else {
            $error[] = 'No user found with this email.';
        }
    }
}
?>
<div class="container d-flex justify-content-center align-items-center" style="min-height:100vh; max-width:750px;">
    <div class="row login-form bg-light shadow rounded">
        <div class="col-sm-12 col-md-6 d-none d-md-block px-0">
            <img class="img-fluid" src="Images/footer/5.jpg" alt="">
        </div>
        <div class="col-sm-12 col-md-6">
            <form method="POST" class="mx-5 log-form">
                <h3>Hello There!</h3>
                <p>Welcome 😊 you’ve been missed. Please enter your data to log in.</p>
                <span class="error-msg"><?php if (!empty($error)) echo '<ul class="error-msg"><li>' . implode('</li><li>', $error) . '</li></ul>'; ?></span>
                <div class="px-0 pt-4">
                    <input class="form-control" type="email" name="email" placeholder="Enter your email" value="<?= htmlspecialchars($email ?? '') ?>">
                </div>
                <div class="form-check px-0 pt-4">
                    <input class="form-control" type="password" name="password" placeholder="Enter your password">
                </div>
                <div class="d-grid">
                    <input id="textchange" type="submit" value="Login Now" class="btn sub-btn btn-block mt-4">
                </div>
                <p class="pt-3">Don't have an account ? <a href="register_form.php"> Sign Up</a></p>
            </form>
        </div>
    </div>
</div>
<?php
include 'footer.php';
?>
