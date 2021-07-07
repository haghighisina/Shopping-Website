<?php session_start();
require_once __DIR__.'/includes.php';
require_once __DIR__.'/functions/product.php';
require_once __DIR__.'/action/cart_action.php';
$products = getAllProduct();
?>
<div class="container container-fluid mb-5">
<div class="card-group">
    <?php if (isAdmin()):;?>
    <div class="col-sm-4 col-md-3 mt-5">
        <div class="card">
            <div class="card-body text-center">
                <a href="new_product.php">
                    <i style="font-size: 5rem" class="fas fa-plus-square"></i>
                </a>
            </div>
        </div>
    </div>
    <?php endif;?>
    <?php foreach ($products as $product):;?>
        <div class="col-sm-4 col-md-3 mt-5">
            <div class="card mx-1">
                <div class="card-title text-center"><?= $product['title']; ?></div>
                <img class="card-img-top zoom" src="<?= $product['pic'] ? $product['pic'] : "asset/image/2.jpg";?>" alt="Card image cap">
                <div class="card-body">
                    <?= $product['description']; ?><hr> <?= convertToMoney($product['price']); ?>
                </div>
                <div class="card-footer">
                    <form action="<?= escape('description.php') ;?>" method="POST" class="form-inline">
                        <input type="hidden" name="product_id" value="<?=$product['id']?? 1;?>">
                        <button type="submit" name="submit" class="btn btn-outline-primary mx-3 btn-sm">Description</button>
                    </form>
                    <form method="POST" action="<?= escape($_SERVER['PHP_SELF']);?>">
<!--                    <a href="--><?php //printf("%s?id=%s&name=%s&product_price=%s",
//                    'cardItems.php',$product['id'], $product['title'], $product['price']);?><!--"-->
<!--                    class="btn btn-success btn-sm ml-2 px-4">Cart</a>-->
                        <input type="hidden" name="product_id" value="<?=$product['id']?? 1;?>">
                        <input type="hidden" name="product_name" value="<?=$product['title']??'product-1';?>">
                        <input type="hidden" name="product_price" value="<?=$product['price']??'60000';?>">
                        <?php if (ifProductExistInCart($userId, $product['id'])):;?>
                        <button type="submit" name="in_cart" class="btn btn-outline-danger disabled mx-3 btn-sm">In cart</button>
                        <?php else:;?>
                        <button type="submit" name="submit" class="btn btn-outline-success mx-3 btn-sm">Submit</button>
                        <?php endif;?>
                        <?php if (isAdmin()):;?>
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Action
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <button type="submit" name="delete" class="btn btn-outline-danger mx-3 btn-sm" onclick="return confirm('Are you sure')">Delete</button>
                                    <a href="<?php printf("%s?product_id=%s",
                                    'edit_product.php',$product['id']);?>"
                                    class="btn btn-outline-primary mx-3 btn-sm">Edit</a>
                                </div>
                            </div>
                        <?php endif;?>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
</div>
<?php require_once __DIR__.'/template/footer.php';?>
