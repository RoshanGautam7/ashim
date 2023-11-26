    <?php
    include('./templates/header.php');
    ?>
    <style>
            .image-container {
      height: 200px; /* Set your desired height */
      width: 100%;
      overflow: hidden;
    }

    .image-container img {
      object-fit: cover;
      object-position: center;
      height: 100%;
      width: 100%;
    }
    </style>
<img src="./images/items/contract.jpg" style="height:50vh; width:100%">
<h4 class="text-center">Auction items</h4>
<div class="container mt-4">
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">

     <?php $items = $database->read('items','isArchived = 0');
     foreach($items as $item):
     ?>
      <div class="col">
        <div class="card">
        <div class="image-container">
            <img src="<?php echo str_replace('../','./',$item['image_url']); ?>" class="card-img-top" alt="Dummy Image">
          </div>
          <div class="card-body">
            <h5 class="card-title">Lot No: <?php echo $item['lot_no']; ?></h5>
            <p class="card-text"><?php echo $item['title']; ?></p>
            <p class="card-text"><?php echo $item['description']; ?></p>
            <p class="card-text">Artist: <?php echo $item['artist']; ?></p>
            <p class="card-text">Category: <?php echo $item['category']; ?></p>
            <p class="card-text">Price: $<?php echo $item['price']; ?></p>
            <p class="card-text">Auction Date: 2023-01-01</p>
            <p class="card-text">Subject Classification: <?php echo $item['subject_classification']; ?></p>
            <a href="#" class="btn btn-primary">Bid Now</a>
          </div>
        </div>
      </div>
      <?php endforeach; ?>

    </div>
  </div>
<?php
    include('./templates/footer.php');
    ?>