<?php require_once __DIR__.'/includes.php';
require_once __DIR__.'/functions/product.php';

if (isPost()){
if (isset($_POST['submit'])) {
    $product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
    $products = getSearchProduct($product_id);
  }
}
?>
<div class="container justify-content-center d-flex">
    <?php foreach ($products as $product):;?>
        <div class="col-sm-4 col-md-3 mt-5">
            <div class="zoom">
                <div class="card-title text-center"><?= $product['title']; ?></div>
                <img class="card-img-top" src="<?= $product['pic']; ?>" alt="Card image cap">
                <div class="card-body">
                    <?= $product['description']; ?><hr> $ <?= convertToMoney($product['price']); ?>
                </div>
                <a href="cardItems.php" class="btn btn-primary text-center d-flex align-center">Back to Products</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php require_once __DIR__.'/template/footer.php';?>
