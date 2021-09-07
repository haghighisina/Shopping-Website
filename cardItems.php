<?php session_start();
require_once __DIR__.'/includes.php';
require_once __DIR__.'/functions/product.php';
$products = getAllProduct();
require_once __DIR__.'/action/cart_action.php';
if(isLoggedIn()){setcookie('allProductsInCartForUser', json_encode($products), strtotime('+30 days'), "/");}
require_once __DIR__.'/action/navbar_filter.php';?>
<nav>
    <ul class="pagination justify-content-center">
        <?php for ($page=1;$page<=$number_of_page;$page++):;?>
            <li class="page-item">
                <a href='<?=escape($_SERVER['PHP_SELF']);?>?page=<?=escape($page);?>' class="page-link">Page ( <?= $page; ?> )</a>
            </li>
        <?php endfor;?>
    </ul>
</nav>
<div class="container container-fluid mb-5">
    <div class="card-group">
    <?php if (isAdmin()):;?>
    <div class="col-sm-4 col-md-3 mt-5">
        <div class="card">
            <div class="card-body text-center">
                <a href="new_product.php">
                    <i style="font-size: 50px" class="fas fa-plus-square"></i>
                </a>
            </div>
        </div>
    </div>
    <?php endif;?>
    <?php foreach ($products as $product):;?>
        <div class="col-sm-6 col-md-4 col-lg-3 mt-5">
            <div class="card mx-1 border-primary">
                <div class="card-title text-center"><?= $product['title'];?></div>
                <img class="card-img-top zoom" style="height: 200px" src="<?= $product['pic'] ? $product['pic'] : "asset/image/2.jpg";?>" alt="Card image cap">
                <div class="card-body">
                    <?= $product['description']; ?><hr> <?= convertToMoney($product['price']); ?>
                </div>
                <div class="card-footer">
                    <form action="<?= escape('description.php') ;?>" method="POST" class="form-inline">
                        <input type="hidden" name="product_id" value="<?=$product['id']?? 1;?>">
                        <button type="submit" name="submit" class="btn btn-outline-primary mx-3 btn-sm descriptionbtn">Description</button>
                    </form>
                    <form method="POST" action="<?= escape($_SERVER['PHP_SELF']);?>" class="todo">
<!--                    <a href="--><?php //printf("%s?id=%s&name=%s&product_price=%s",
//                    'cardItems.php',$product['id'], $product['title'], $product['price']);?><!--"-->
<!--                    class="btn btn-success btn-sm ml-2 px-4">Cart</a>-->
                        <input type="hidden" name="product_id" value="<?=$product['id']?? 1;?>">
                        <input type="hidden" name="product_name" value="<?=$product['title']??'product-1';?>">
                        <input type="hidden" name="product_price" value="<?=$product['price']??'60000';?>">
                        <?php if (ifProductExistInCart($userId, $product['id'])):;?>
                        <button type="submit" name="in_cart" class="btn btn-outline-danger disabled mx-3 btn-sm">In cart</button>
                        <?php else:;?>
                        <button type="submit" name="submit" class="btn btn-outline-success mx-3 btn-sm submitbtn">Submit</button>
                        <?php endif;?>
                        <?php if (isAdmin()):;?>
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Action
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <button type="submit" name="delete" class="btn btn-outline-danger mx-3 btn-sm" onclick="return confirm('Are you sure')">Delete</button>
                                    <a href="<?php escape(printf("%s?productId=%s&categoryId=%s",
                                    'edit_product.php',$product['id'],$product['category_id']));?>"
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
