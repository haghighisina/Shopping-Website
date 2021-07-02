<?php session_start();
require_once __DIR__.'/includes.php';
require_once __DIR__.'/functions/product.php';
require_once __DIR__.'/action/cart_action.php';
if (isset($_GET['product_id'])){
    $product_id = (int)filter_input(INPUT_GET,'product_id',FILTER_SANITIZE_NUMBER_INT);
    $products = getProductById($product_id);
}
if (isAdmin()):;?>
    <div class="container mt-5">
        <?php
        if (!empty($products)):;
            foreach ($products as $product):;?>
                <form action="<?= escape($_SERVER['PHP_SELF']);?>" method="POST" enctype="multipart/form-data">
                    <?php require_once __DIR__.'/errorMessages.php';?>
                    <div class="card">
                        <div class="card-header">
                            Edit The Product
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Product Name</label>
                                <input type="text" name="name" value="<?= $product['title']??'Product-1'?>" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="description">Product Description</label>
                                <input type="text" name="description" value="<?= $product['description']??'Product-1'?>" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="price">Product Price</label>
                                <input type="text" name="price" value="<?= $product['price']?? 100?>" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="image">Product Image</label>
                                <input type="file" name="image[]" class="form-control">
								<image src="<?= $product['pic'];?>" style="width:100px">
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="index.php" class="btn btn-danger">Cancel</a>
                            <input type="hidden" name="product_id" value="<?= $product['id']?? 1;?>">
                            <button class="btn btn-success" type="submit" name="edit_submit">Save</button>
                        </div>
                    </div>
                </form>
            <?php endforeach;
            else:notificationErrorMessage("The image was empty");
            header("location:".SITE_URL."cardItems.php");
            exit;
        endif;?>
    </div>
<?php else:header("location:".SITE_URL);endif;?>
