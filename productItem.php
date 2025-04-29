
<!-- Prewritten design and layout of a product, so it reduces amount of repetive code for a product page php file  -->
<div class="col-md-auto">
<div class="card" style="width: 18rem;" >
  <img src="<?php echo $imgSrc; ?>" class="card-img-top" alt="<?php echo $imgAlt; ?>">
  <div class="card-body">
    <h5 class="card-title" style="font-size:1.3em; font-weight:275;"><?php echo $productTitle; ?></h5>
    <p class="card-text"><?php echo $productText; ?></p>
    <a href="contact.php" class="btn btn-primary"><?php echo $productButton; ?></a>
  </div>
</div>
</div>