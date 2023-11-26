<?php
include('./templates/header.php');

if (isset($_GET['delete_id'])) {
    $id = $_GET['delete_id'];
   $database->delete('items',"lot_no=$id");
} elseif (isset($_GET['archive_id'])) {
    $lot_no = $_GET['archive_id'];
    $data = ['isArchived'=>1];
    $database->update('items',$data,array('lot_no'=>$lot_no));
}elseif (isset($_GET['unarchive_id'])) {
    $lot_no = $_GET['unarchive_id'];
    $data=['isArchived'=>0];
    $database->update('items',$data,array('lot_no'=>$lot_no));
}
?>
<div class="container mt-5">
<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal">
        Add
    </button>

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
      $datas = $database->read('items','isArchived = 0');

        // Loop through dummy data to generate table rows
        foreach ($datas as $data) {
            echo '<tr>';
            echo '<td>' . $data['lot_no'] . '</td>';
            echo '<td>' . $data['title'] . '</td>';
            echo '<td>' . $data['price'] . '</td>';
            echo '<td>' . $data['auction_date'] . '</td>';
            echo '<td>'; ?>
                    <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal" data-id ='.$data['lot_number'].'>Edit</button> -->
                    <button type="button" class="btn btn-primary btn_edit" data-bs-toggle="modal" data-bs-target="#editModal"
        data-lot="<?= $data['lot_no'] ?>"
        data-title="<?= htmlspecialchars($data['title']) ?>"
        data-description="<?= htmlspecialchars($data['description']) ?>"
        data-artist="<?= htmlspecialchars($data['artist']) ?>"
        data-category="<?= htmlspecialchars($data['category']) ?>"
        data-price="<?= htmlspecialchars($data['price']) ?>"
        data-auction-date="<?= htmlspecialchars($data['auction_date']) ?>"
        data-classification="<?= htmlspecialchars($data['subject_classification']) ?>"
        data-image-url="<?= htmlspecialchars($data['image_url']) ?>">
    Edit
</button>

                    <a href="auctions.php?delete_id=<?php echo $data['lot_no']; ?>" class="btn btn-danger">Delete</a>
                    <a href="auctions.php?archive_id=<?php echo $data['lot_no']; ?>" class="btn btn-success">Archive</a>
                 <?php echo '</td>';
            echo '</tr>';
        }
        ?>
        </tbody>
    </table>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery (required for Bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    
        $('.btn_edit').on('click', function (event) {
            var button = $(this);
            var lotNumber = button.data('lot');

            $('#lot_number').val(lotNumber);
            $('#title').val(button.data('title'));
            $('#description').val(button.data('description'));
            $('#artist').val(button.data('artist'));
            $('#category').val(button.data('category'));
            $('#price').val(button.data('price'));
            $('#auctionDate').val(button.data('auction-date'));
            $('#classification').val(button.data('classification'));
            $('#previewImage').attr('src', button.data('image-url'));

        });

    </script>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve data from the form
        
        $title = $_POST['title'];
        $description = $_POST['description'];
        $artist = $_POST['artist'];
        $category = $_POST['category'];
        $price = $_POST['price'];
        $auctionDate = $_POST['auctionDate'];
        $classification = $_POST['classification'];
    
        // Handle image upload
        $targetDirectory = '../images/items/';
        $targetFile = $targetDirectory . basename($_FILES["image"]["name"]);
    
        // Move the uploaded file to the specified directory without validation
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            echo "The file ". htmlspecialchars( basename( $_FILES["image"]["name"])). " has been uploaded.";
        }
    
        // Adjust the method signature and functionality based on your database class
        $data = array(
            'title' => $title,
            'description' => $description,
            'artist' => $artist,
            'category' => $category,
            'price' => $price,
            'auction_date' => $auctionDate,
            'subject_classification' => $classification,
            'image_url' => $targetFile,  // Save the file path to the database
        );
    
       
        if (!empty($_POST['lot_number'])) {
            $result = $database->update('items',$data, array('lot_no'=>$_POST['lot_number']));
            
        }else{
            $result = $database->create('items', $data);
        }
        // Check if the insertion was successful
        if ($result) {
            header('Location:auctions.php');
        } else {
            echo "Error adding product to the database.";
        }
    }
    ?>
    
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Item</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form for editing item -->
                <form method="POST" action="" enctype="multipart/form-data">
                    <input type="number" class="form-control" id="lot_number" name="lot_number" hidden value="">

                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="artist" class="form-label">Artist</label>
                        <input type="text" class="form-control" id="artist" name="artist">
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <input type="text" class="form-control" id="category" name="category">
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="text" class="form-control" id="price" name="price">
                    </div>
                    <div class="mb-3">
                        <label for="auctionDate" class="form-label">Auction Date</label>
                        <input type="date" class="form-control" id="auctionDate" name="auctionDate">
                    </div>
                    <div class="mb-3">
                        <label for="classification" class="form-label">Classification</label>
                        <input type="text" class="form-control" id="classification" name="classification">
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" class="form-control" id="image" name="image">
                    </div>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>
   <!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Add Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form for adding a new product -->
                <form method="POST" action="" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" id="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" name="description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="artist" class="form-label">Artist</label>
                        <input type="text" class="form-control" name="artist" required>
                    </div>
                         <div class="mb-3">
                        <label for="classification" class="form-label">Classification</label>
                        <select class="form-select" id="classification" name="classification" required>
                            <option value="abstract">Abstract</option>
                            <option value="portrait">Portrait</option>
                            <option value="landscape">Landscape</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select class="form-select" id="category" name="category" required>
                            <option value="painting">Painting</option>
                            <option value="sculpture">Sculpture</option>
                            <option value="photography">Photography</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" class="form-control" name="price" required>
                    </div>
                    <div class="mb-3">
                        <label for="auctionDate" class="form-label">Auction Date</label>
                        <input type="date" class="form-control" name="auctionDate" required>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" class="form-control" name="image" accept="image/*" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
include('./templates/footer.php');
?>

</div>