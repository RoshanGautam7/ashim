<?php
include('./templates/header.php');

if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
   $database->delete('users',"id=$id");
}
?>
<div class="container mt-5">


    <!-- Table with dummy data -->
    <table class="table mt-4">
        <thead>
        <tr>
            <th scope="col">Name</th>
            <th scope="col">Email</th>
            <th scope="col">Address</th>
            <th scope="col">Pincode</th>
            <th scope="col">Type</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        <?php
      $datas = $database->read('users');

        // Loop through dummy data to generate table rows
        foreach ($datas as $data) {
            if ($data['type']=='admin') {
               break;
            }
            echo '<tr>';
            echo '<td>' . $data['name'] . '</td>';
            echo '<td>' . $data['email'] . '</td>';
            echo '<td>' . $data['address'] . '</td>';
            echo '<td>' . $data['pincode'] . '</td>';
            echo '<td>' . $data['type'] . '</td>';
            echo '<td>'; ?>
                    <a href="users.php?delete_id=<?php echo $data['id']; ?>" class="btn btn-danger">Delete</a>
                 <?php echo '</td>';
            echo '</tr>';
        }
        ?>
        </tbody>
    </table>
    <?php
    
    include './templates/footer.php';
    ?>