<?php session_start();
require_once __DIR__.'/includes.php';
if (isPost()){
if (isset($_POST['submitSearch'])){
    $search = filter_input(INPUT_POST, 'search', FILTER_SANITIZE_SPECIAL_CHARS);
    if (empty($search)){
        notificationErrorMessage('The input is empty');
        header('location: index.php');
        exit();
    }
    $results = search($search);
    if (!$results):;?>
        <?php
        notificationErrorMessage('Sorry Nothing was found');
        header('location: index.php');
        exit();
        ?>
    <?php else:;?>
    <div class="container">
        <?php foreach ($results as $result):;?>
            <div class="col-lg-6 mt-5 m-auto justify-content-center">
                <div class="card">
                    <div class="card-header">
                        <?= $result['title']; ?>
                    </div>
                    <div class="card-body">
                        <div><?= $result['description']; ?></div>
                        <div>
                            <img class="card-img-top" src="<?= $result['pic']; ?>">
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex">
                            <div class="col-4">
                                Prise: <b><?= convertToMoney($result['price']);?></b>
                            </div>
                            <div class="col-8">
                                <form  action="<?= escape('description.php');?>" method="POST">
                                    <input type="hidden" name="product_id" value="<?=$result['id']?? 1;?>">
                                    <button type="submit" name="submit" class="btn btn-success align-content-start d-flex btn-sm">Show Detail</button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif;}}?>
<?php require_once __DIR__.'/template/footer.php';?>





