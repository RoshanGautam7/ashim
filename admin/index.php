<?php
session_start();
require_once('../application/databasehandler.php');
$database = new DatabaseHandler();

if (isset($_SESSION['role'])) {
  if ($_SESSION['role']=='admin') {
    header('Location:auctions.php');
  }
  
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>
<body>

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card">
        <div class="card-header">
          Login
        </div>
        <div class="card-body">
         <?php
         if (isset($_POST['submit'])) {
            $email = $_POST['inputEmail'];
            $pass = $_POST['inputPassword'];

            $confirm = $database->loginUser($email,$pass);
            if ($confirm) {
                header('Location:auctions.php');
            }
         }
         ?>
          <form action="" method="post">
            <div class="mb-3">
              <label for="inputEmail" class="form-label">Email</label>
              <input type="email" class="form-control" id="inputEmail" name="inputEmail" required>
            </div>
            <div class="mb-3">
              <label for="inputPassword" class="form-label">Password</label>
              <input type="password" class="form-control" id="inputPassword" name="inputPassword" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Login</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-pzjw8i+JpLXR5qX5KTEJ5u8ZTqzQ1Ls9ZQCGO5uY2nqAJKQ5Nz56e7/jQ9WOahdz" crossorigin="anonymous"></script>
</body>
</html>
