<?php
require 'auth.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $error = signup($username, $password);
}
?>

<?php include 'header.php'; ?>
<div class="row justify-content-center">
    <div class="col-md-4">
        <h2 class="text-center">Sign Up</h2>
        <form method="POST" action="" class="needs-validation" novalidate>
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
                <div class="invalid-feedback">Please enter a username.</div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
                <div class="invalid-feedback">Please enter a password.</div>
            </div>
            <button type="submit" class="btn btn-primary w-100">Sign Up</button>
            <div class="text-danger mt-3"><?php echo $error; ?></div>
            <p class="text-center mt-3">Already have an account? <a href="index.php">Login</a></p>
        </form>
    </div>
</div>
<?php include 'footer.php'; ?>
