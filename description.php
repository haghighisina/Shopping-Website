<?php session_start();
require_once __DIR__.'/includes.php';
require_once __DIR__.'/functions/product.php';
if (isPost()){
    if (isset($_POST['submit'])) {
        $product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
        $products = getSearchProduct($product_id);
      }
}?>
<section class="container mt-5">
    <?php foreach ($products as $product):;?>
    <div class="card">
        <div class="card-header">
            <h2><?= $product['title'] ;?></h2>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-4 zoom">
                    <img class="card-img-top" src="<?= $product['pic']; ?>" alt="Card image cap">
                </div>
                <div class="col-8">
                    <div>Prise: <b><?= convertToMoney($product['price']);?></b></div>
                    <hr>
                    <div><?= $product['description'];?></div>
                </div>
            </div>
            <div class="card-footer">
                <a href="cardItems.php" class="btn btn-primary text-center d-flex align-center">Back to Products</a>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</section>
<?php require_once __DIR__.'/template/footer.php';?>
