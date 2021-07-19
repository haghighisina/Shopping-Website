<?php session_start();
require_once __DIR__.'/includes.php';
//check if the user-agent used at login time
if(false === (bool)ifUserAgentMatche()){header("location: login.php");exit();}
redirectIfNotLogged($_SERVER['PHP_SELF']);
require_once __DIR__.'/action/product_action.php';
$allProducts = getCartAllItemsForUserId($userId);
setcookie('allProductsInCartForUser', json_encode($allProducts), strtotime('+30 days'), "/");
if (isLoggedIn()):;?>
<div class="flex-row d-flex justify-content-center mt-3 mb-3"><h2 style="font-family: 'Pacifico';color: forestgreen">Cart</h2></div>
<section class="container" id="cartItems">
<?php foreach ($allProducts as $product):;?>
    <div class="row cartItem border-bottom pt-3 pb-3">
        <div class="col-3 zoom">
            <img class="card-img-top" src="<?= $product['pic']; ?>" alt="Card image cap">
        </div>
        <div class="col-2 font-weight-bold text-danger">
            <span><?= $product['title'];?> - <?= $product['description'];?></span>
            <h6 class="text-primary"><?= $product['created'];?></h6>
        </div>
        <div class="col-3">
            <a href="shopping_cart.php?delete=delete&id=<?= $product['product_id'];?>"
               class="product_id btn btn-danger btn-sm " onclick="return confirm('Are you sure') ">Delete</a>
        </div>
        <div class="col-2">
            <form action="<?= escape($_SERVER['PHP_SELF']);?>" method="POST" class="MyClass">
                <input type="hidden" name="productPrice" value="<?= $product['price'];?>">
                <input type="hidden" name="productId" value="<?= $product['product_id'];?>">
                <input type="number" name="itemQuantity" class="form-control w-100" max="10" value="<?= $product['quantity'];?>">
                <input type="submit" name="submit" class="btn btn-primary form-control">
            </form>
        </div>
        <div class="col-2 text-danger text-right">
            <span class="font-weight-bold"><?= convertToMoney($product['product_price']);?>&nbsp;€</span>
        </div>
    </div>
<?php endforeach ;?>
    <div class="d-flex justify-content-end">
        <a href="shopping_cart.php?action=Clear_Cart" class="btn btn-danger col-2 clear-cart
    <?= $cartItems >= 1 ? '' : 'disabled';?>" onclick="return confirm('Are you sure')">Clear Cart</a>
        &nbsp; <span class="text-success"><?= $cartItems; ?> &nbsp;</span> Artikel:&nbsp;
        <span class="text-danger font-weight-bold">
    <?= convertToMoney($cartSum);?> €
    </span>
    </div>
    <div class="row cart-checkout">
        <a href="checkout.php" class="btn btn-primary col-12">Go to Cart</a>
    </div>
</section>
<?php endif;?>
<?php require_once __DIR__.'/template/footer.php';?>

