<?php
ob_start();
session_start();
require_once('../application/databasehandler.php');
$database = new DatabaseHandler();

if (($_SESSION['role'])!='admin') {
   header('Location:index.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Auction Page</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<section id="header">
    <nav class="navbar navbar-expand-lg navbar-light">
      <div class="container-fluid">
        <a href="#"><img src="../images/logo.jpg" class="logo" alt=""></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse">
          <div class="row w-100">
            <div class="col-lg-6 d-flex justify-content-center">
              <ul class="navbar-nav">
                <li class="nav-item">
                  <a class="nav-link" href="auctions.php">Auction</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="archive.php">Archived Products</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="users.php">Users</a>
                </li>
              </ul>
            </div>
            <div class="col-lg-6 d-flex justify-content-end">
            <?php
            if(isset($_SESSION['username'])):
            ?>
              <ul class="navbar-nav">
                <li class="nav-item">
                  <a class="nav-link" href="#"><?php echo $_SESSION['username']; ?></a>
            </li>
            <li class="nav-item">
                <a href="../logout.php">Logout</a>
            </li>
              </ul> 
              <?php else: ?>
                <ul class="navbar-nav">
                <li class="nav-item">
                  <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#registerModal">Register</a>
                </li>
              </ul>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </div>
    </nav>
  </section>



  