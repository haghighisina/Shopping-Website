<?php require_once __DIR__.'/includes.php';
if (isPost()){
if (isset($_POST['submitSearch'])){
    $search = $_POST['search'];
    $results = search($search);
if (!$results):;?>
    <div class='container'>Sorry Nothing was found</div>
<?php else:;?>
<div class="container">
    <?php foreach ($results as $result):;?>
        <div class="col-sm-4 col-md-3 mt-5">
            <div class="card zoom">
                <div class="card-title text-center"><?= $result['title']; ?></div>
                <div class="card-title text-center"><?= $result['description']; ?></div>
            </div>
            <form action="description.php" method="post">
                <img class="card-img-top" src="<?= $result['pic']; ?>">
                <input type="hidden" name="product_id" value="<?=$result['id']?? 1;?>">
                <button type="submit" name="submit" class="btn btn-success justify-content-center d-flex mx-3 btn-sm">Show Detail</button>
            </form>
            <div class="card-body">
                <?= $result['description']; ?><hr> $ <?= convertToMoney($result['price']); ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php endif;}}?>
<?php require_once __DIR__.'/template/footer.php';?>





