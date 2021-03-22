<?php session_start();
require_once __DIR__.'/includes.php';
require_once __DIR__.'/functions/product.php';
require_once __DIR__.'/action/cart_action.php';
$products = getAllProduct();
?>
<div class="container container-fluid">
<div class="card-group">
    <?php foreach ($products as $product):;?>
        <div class="col-sm-4 col-md-3 mt-5">
            <div class="card zoom">
                <div class="card-title text-center"><?= $product['title']; ?></div>
                <img class="card-img-top" src="<?= $product['pic']; ?>" alt="Card image cap">
                <div class="card-body">
                    <?= $product['description']; ?><hr> $ <?= convertToMoney($product['price']); ?>
                </div>
                <div class="card-footer">
                    <form action="description.php" method="POST" class="form-inline">
                        <input type="hidden" name="product_id" value="<?=$product['id']?? 1;?>">
                        <button type="submit" name="submit" class="btn btn-primary mx-3 btn-sm">Description</button>
                    </form>
                    <form method="POST" action="<?= escape($_SERVER['PHP_SELF']);?>" class="align-content-end">
<!--                    <a href="--><?php //printf("%s?id=%s&name=%s&product_price=%s",
//                    'cardItems.php',$product['id'], $product['title'], $product['price']);?><!--"-->
<!--                    class="btn btn-success btn-sm ml-2 px-4">Cart</a>-->
                        <input type="hidden" name="product_id" value="<?=$product['id']?? 1;?>">
                        <input type="hidden" name="product_name" value="<?=$product['title']??'product-1';?>">
                        <input type="hidden" name="product_price" value="<?=$product['price']??'60000';?>">
                        <?php if (ifProductExistInCart($userId, $product['id'])):;?>
                        <button type="button" name="submit" class="btn btn-danger mx-3 btn-sm">In cart</button>
                        <?php else:;?>
                        <button type="submit" name="submit" class="btn btn-success mx-3 btn-sm">Submit</button>
                        <?php endif;?>
                    </form>

                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
</div>
<?php require_once __DIR__.'/template/footer.php';?>
