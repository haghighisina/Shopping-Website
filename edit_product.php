<?php session_start();
require_once __DIR__.'/includes.php';
redirectIfNotLogged($_SERVER['PHP_SELF']);
require_once __DIR__.'/functions/product.php';
require_once __DIR__.'/action/cart_action.php';
if (isAdmin()):;?>
<div class="container mt-5">
    <?php if (!empty($productsById)):; foreach ($productsById as $product):;?>
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
                            <label for="categories">Categories</label>
                            <ul>
                                <li>
                                    <a href="<?php escape(printf("%s?category_id=%s&product_id=%s","edit_product.php",0,$product['id']));?>">ALL Categories</a>
                                </li>
                                <?php if (isset($categories) && !empty($categories)): foreach($categories as $category):;?>
                                <li>
                                    <a href="<?php escape(printf("%s?category_id=%s&product_id=%s","edit_product.php",$category['id'],$product['id']));?>">
                                    <?php if (true === (bool)$category['isPrimary']):;?>
                                        <strong><?= $category['label'];?></strong>
                                        <?php else: echo  $category['label'];?>
                                    <?php endif; ?>
                                    </a>
                                </li>
                                <?php endforeach;endif;?>
                                <?php
                                if ($product['category_id']===null):;?>
                                    <?php foreach($allCategories as $category):;?>
                                        <li>
                                            <a href="<?php escape(printf("%s?category_id=%s&product_id=%s","edit_product.php",$category['id'],$product['id']));?>">
                                            <?= $category['label'];?>
                                            </a>
                                        </li>
                                    <?php endforeach;?>
                                <?php endif;?>
                            </ul>
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
                        <a href="cardItems.php" class="btn btn-danger">Cancel</a>
                        <input type="hidden" name="product_id" value="<?= $product['id']?? 1;?>">
                        <button class="btn btn-success" type="submit" name="edit_submit">Save</button>
                    </div>
                </div>
            </form>
        <?php endforeach;
//            else:
//
//            header("location: cardItems.php");
//            exit;
    endif;?>
</div>
<?php else:header("location:".SITE_URL);endif;?>
