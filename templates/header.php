<?php
session_start();
require_once('./application/databasehandler.php');
$database = new DatabaseHandler();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <section id="header">
    <nav class="navbar navbar-expand-lg navbar-light">
      <div class="container-fluid">
        <a href="#"><img src="images/logo.jpg" class="logo" alt=""></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse">
          <div class="row w-100">
            <div class="col-lg-6 d-flex justify-content-center">
              <ul class="navbar-nav">
                <li class="nav-item">
                  <a class="nav-link" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="about.php">About Us</a>
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
                <a href="logout.php">Logout</a>
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

  <!-- Your content goes here -->

  <?php
  if (isset($_POST['loginSubmit'])) {
    $email = $_POST['loginEmail'];
    $password = $_POST['loginPassword'];

    $confirm = $database->loginUser($email,$password);

    if ($confirm) {
       header('Location:index.php');
    }
  }
  ?>

  <!-- Login Modal -->
  <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="loginModalLabel">Login</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <form id="loginForm" action="" method="post">
          <div class="mb-3">
            <label for="loginEmail" class="form-label">Email</label>
            <input type="email" class="form-control" id="loginEmail" name="loginEmail" required>
          </div>
          <div class="mb-3">
            <label for="loginPassword" class="form-label">Password</label>
            <input type="password" class="form-control" id="loginPassword" name="loginPassword" required>
          </div>
          <button type="submit" name="loginSubmit" class="btn btn-primary">Login</button>
        </form>
        </div>
      </div>
    </div>
  </div>
<?php

    if (isset($_POST['submit'])) {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
        $address = $_POST['address'];
        $pincode = $_POST['pincode'];
        $type = $_POST['type'];
        $userImage = $_FILES['userImage']; // Use $_FILES to access file upload data
        
        // Create an associative array with the form data
        $data = array(
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'address' => $address,
            'pincode' => $pincode,
            'type' => $type,
            'user_image_path' => ''
        );
        
        // Check if an image was uploaded
        if ($userImage['error'] === 0) {
            // Get the temporary filename of the file
            $tmpFileName = $userImage['tmp_name'];
        
            // Generate a unique filename for the image
            $imageName = uniqid('user_') . '_' . $userImage['name'];
        
            // Set the path where the image will be saved
            $uploadPath = './images/users/' . $imageName;
        
            // Move the uploaded file to the destination folder
            if (move_uploaded_file($tmpFileName, $uploadPath)) {
                // Update the 'user_image_path' in the $data array with the relative path to the image
                $data['user_image_path'] = './images/users/' . $imageName;
            } else {
                // Handle file upload error
                echo "Failed to upload the image.";
            }
        }
        
        // Assuming $database->create() is a method that inserts data into the 'users' table
        $database->create('users', $data);
    }

?>
  <!-- Register Modal -->
  <div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="registerModalLabel">Register</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <form action="" method="post" enctype="multipart/form-data">
  <div class="mb-3">
    <label for="name" class="form-label">Name</label>
    <input type="text" class="form-control" id="name" name="name" required>
  </div>
  <div class="mb-3">
    <label for="email" class="form-label">Email</label>
    <input type="email" class="form-control" id="email" name="email" required>
  </div>
  <div class="mb-3">
    <label for="password" class="form-label">Password</label>
    <input type="password" class="form-control" id="password" name="password" required>
  </div>
  <div class="mb-3">
    <label for="address" class="form-label">Address</label>
    <input type="text" class="form-control" id="address" name="address" required>
  </div>
  <div class="mb-3">
    <label for="pincode" class="form-label">Pincode</label>
    <input type="text" class="form-control" id="pincode" name="pincode" required>
  </div>
  <div class="mb-3">
    <label for="type" class="form-label">Type</label>
    <select class="form-select" id="type" name="type" required>
      <option value="buyer">Buyer</option>
      <option value="seller">Seller</option>
    </select>
  </div>
  <div class="mb-3">
    <label for="userImage" class="form-label">Upload Image</label>
    <input type="file" class="form-control" id="userImage" name="userImage" accept="image/*" required>
  </div>
  <button type="submit" name="submit" class="btn btn-primary">Register</button>
</form>
        </div>
      </div>
    </div>
  </div>

