<?php session_start();
require_once __DIR__.'/includes.php';
require_once __DIR__.'/functions/product.php';
require_once __DIR__.'/action/cart_action.php';
if (isLoggedIn()){setcookie('allProductsInCartForUser',json_encode(getAllProduct()),strtotime('+30 days'), "/");}
require_once __DIR__.'/action/navbar_filter.php';
require_once __DIR__.'/errorMessages.php';?>
<div class="container container-fluid mb-5">
    <div class="card-group">
        <?php if (isset($filter_products) && !empty($filter_products)): foreach ($filter_products as $product):;?>
                <div class="col-sm-6 col-md-4 col-lg-3 mt-5">
                    <div class="card mx-1 border-primary">
                        <div class="card-title text-center"><?= $product['title'];?></div>
                        <div class="card-title text-center"><?= substr($product['time'],0,10);?></div>
                        <img class="card-img-top zoom" style="height: 200px" src="<?= $product['pic'] ? $product['pic'] : "asset/image/2.jpg";?>" alt="Card image cap">
                        <div class="card-body">
                            <?= $product['description']; ?><hr> <?= convertToMoney($product['price']); ?>
                        </div>
                        <div class="card-footer">
                            <form action="<?= escape('description.php');?>" method="POST" class="form-inline">
                                <input type="hidden" name="product_id" value="<?=$product['id']?? 1;?>">
                                <button type="submit" name="submit" class="btn btn-outline-primary mx-3 btn-sm descriptionbtn">Description</button>
                            </form>
                            <form method="POST" action="<?= escape($_SERVER['PHP_SELF']);?>" class="todo">
                                <input type="hidden" name="product_id" value="<?=$product['id']?? 1;?>">
                                <input type="hidden" name="product_name" value="<?=$product['title']??'product-1';?>">
                                <input type="hidden" name="product_price" value="<?=$product['price']??'60000';?>">
                                <?php if (ifProductExistInCart($userId, $product['id'])):;?>
                                    <button type="submit" name="in_cart" class="btn btn-outline-danger disabled mx-3 btn-sm">In cart</button>
                                <?php else:;?>
                                    <button type="submit" name="submit" class="btn btn-outline-success mx-3 btn-sm submitbtn">Submit</button>
                                <?php endif;?>
                            </form>
                        </div>
                    </div>
                </div>
        <?php endforeach;
        else: if (empty($filter_products)) echo "<div class='container alert alert-danger'>Sorry, nothig was found</div>";
        endif;?>
    </div>
</div>
<?php require_once __DIR__.'/template/footer.php';?>