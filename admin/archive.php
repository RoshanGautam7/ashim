<?php
include('./templates/header.php');

if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
   $database->delete('items',"lot_no=$id");
} elseif (isset($_GET['archive_id'])) {
    $lot_no = $_GET['archive_id'];
    $data = ['isArchived'=>1];
    $database->update('items',$data,array('lot_no'=>$lot_no));
}
?>
<div class="container mt-5">


    <!-- Table with dummy data -->
    <table class="table mt-4">
        <thead>
        <tr>
            <th scope="col">Lot Number</th>
            <th scope="col">Product Name</th>
            <th scope="col">Product Price</th>
            <th scope="col">Auction Date</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        <?php
      $datas = $database->read('items','isArchived = 1');

        // Loop through dummy data to generate table rows
        foreach ($datas as $data) {
            echo '<tr>';
            echo '<td>' . $data['lot_no'] . '</td>';
            echo '<td>' . $data['title'] . '</td>';
            echo '<td>' . $data['price'] . '</td>';
            echo '<td>' . $data['auction_date'] . '</td>';
            echo '<td>'; ?>
                    <a href="auctions.php?unarchive_id=<?php echo $data['lot_no']; ?>" class="btn btn-success">UnArchive</a>
                 <?php echo '</td>';
            echo '</tr>';
        }
        ?>
        </tbody>
    </table>
    <?php
    
    include './templates/footer.php';
    ?>