<?php
include 'header.php';
include 'config.php';

$error = [];
$user_type = 'user'; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name'] ?? '');
    $email = mysqli_real_escape_string($conn, $_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['cpassword'] ?? '';
    $user_type = $_POST['user_type'] ?? 'user'; 

    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        $error[] = 'All fields are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error[] = 'Invalid email format.';
    } elseif ($password !== $confirm_password) {
        $error[] = 'Passwords do not match.';
    } else {
        $query = "SELECT * FROM user_form WHERE email = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $error[] = 'User already exists.';
        } else {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $query = "INSERT INTO user_form (name, email, password, user_type) VALUES (?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, 'ssss', $name, $email, $hashed_password, $user_type);
            mysqli_stmt_execute($stmt);

            header('Location: login_form.php');
            exit;
        }
    }
}
?>

<div class="container d-flex justify-content-center align-items-center" style="min-height:90vh; max-width:750px;">
    <div  class="row login-form bg-light shadow rounded">
        <div class="col-sm-12 col-md-6 d-none d-md-block px-0">
            <img class="img-fluid" src="Images/footer/5.jpg" alt="">
        </div>
        <div class="col-sm-12 col-md-6">
            <form method="post" class="mx-5 log-form">
                <h3>Hello There!</h3>
                <p>Glad to see you joining us. Please fill up the following fields to set your account up.</p>
                <span class="error-msg"><?php if (!empty($error)) echo '<ul class="error-msg"><li>' . implode('</li><li>', $error) . '</li></ul>'; ?></span>
                <div class="px-0 pt-2">
                    <input class="form-control" type="text" name="name" placeholder="Enter your name" value="<?= htmlspecialchars($name ?? '') ?>">
                </div>
                <div class="px-0 pt-2">
                    <input class="form-control" type="email" name="email" placeholder="Enter your email" value="<?= htmlspecialchars($email ?? '') ?>">
                </div>
                <div class="px-0 pt-2">
                    <input class="form-control" type="password" name="password" placeholder="Enter your password">
                </div>
                <div class="px-0 pt-2">
                    <input class="form-control" type="password" name="cpassword" placeholder="Confirm your password">
                </div>
                <div name="user_type" class="mt-3">
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="radio1" name="user_type" value="user" <?= $user_type === 'user' ? 'checked' : '' ?>> 
                        <label class="form-check-label" for="radio1">User</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input" id="radio2" name="user_type" value="admin" <?= $user_type === 'admin' ? 'checked' : '' ?>> 
                        <label class="form-check-label" for="radio2">Admin</label>
                    </div>
                </div>

                
                <div class="d-grid">
                    <input type="submit" value="Register Now" class="btn sub-btn btn-block mt-4">
                </div>
                <p class="pt-3">Already have an account ?<a href="login_form.php">Login</a></p>
            </form>
        </div>
    </div>
</div>

<?php
include 'footer.php';
?>
