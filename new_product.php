<?php session_start();
require_once __DIR__.'/includes.php';
require_once __DIR__.'/action/cart_action.php';
if (isAdmin()):;?>
<div class="container mt-5">
    <form action="<?= escape($_SERVER['PHP_SELF']);?>" method="POST" enctype="multipart/form-data">
        <?php require_once __DIR__.'/errorMessages.php';?>
        <div class="card">
            <div class="card-header">
                Create New Product
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label for="name">Product Name</label>
                    <input type="text" name="name" value="<?= empty($product_title) ? '' : $product_title;?>" class="form-control">
                </div>
                <div class="form-group">
                    <label for="description">Product Description</label>
                    <input type="text" name="description" value="<?= empty($description) ? '' : $description;?>" class="form-control">
                </div>
                <div class="form-group">
                    <label for="price">Product Price</label>
                    <input type="text" name="price" value="<?= empty($price) ? '' : $price;?>" class="form-control">
                </div>
                <div class="form-group">
                    <label for="image">Product Image</label>
                    <input type="file" name="image[]" class="form-control">
                </div>
            </div>
            <div class="card-footer">
                <a href="index.php" class="btn btn-danger">Cancel</a>
                <button class="btn btn-success" type="submit" name="new_submit">Save</button>
            </div>
        </div>
    </form>
</div>
<?php else:header("location: ". SITE_URL);endif;?>
