<?php /* @noinspection All */
if (isPost()) {
    if (isset($_POST['submit'])) {
        $product_name = filter_input(INPUT_POST, 'product_name', FILTER_SANITIZE_SPECIAL_CHARS);
        $product_id = (int)filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
        $product_price = (int)filter_input(INPUT_POST, 'product_price', FILTER_SANITIZE_SPECIAL_CHARS);
        if (isLoggedIn()) {
            if (ifProductExistInCart($userId, $product_id)) {
                notificationErrorMessage('product has already exist in cart');
                header('location: ' . $_SERVER['PHP_SELF']);
                exit();
            } else {
                addToCart($userId, $product_name, $product_id, $product_price);
                notificationMessage("product ".$product_name." has added in cart");
                header('location: ' . $_SERVER['PHP_SELF']);
                exit();
            }
        } elseif (!isLoggedIn()) {
            notificationErrorMessage('You must log in first');
            header('location: ' . $_SERVER['PHP_SELF']);
            exit();
        }
    }
    if (isset($_POST['in_cart'])) {
        notificationErrorMessage('product has been already added in cart');
        header('location: ' . $_SERVER['PHP_SELF']);
        exit();
    }
    if (isAdmin()) {
        //Delete Product
        if (isset($_POST['delete'])) {
            $product_id = (int)filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
            $product_name = filter_input(INPUT_POST, 'product_name', FILTER_SANITIZE_SPECIAL_CHARS);
            deleteProduct($product_id);
            notificationMessage("product " . $product_name . " has deleted from product section");
            header('location: ' . $_SERVER['PHP_SELF']);
            exit();
        }
        //New Product
        $product_title = "";
        $description = "";
        $price = 0;
        $errors = [];
        $hasErrors = false;
        require_once __DIR__ .'/../functions/product.php';
        if (isset($_POST['new_submit'])) {
            $product_title = filter_input(INPUT_POST, "name", FILTER_SANITIZE_SPECIAL_CHARS);
            $description = filter_input(INPUT_POST, "description", FILTER_SANITIZE_SPECIAL_CHARS);
            $price = (int)filter_input(INPUT_POST, "price");
            if (false === (bool)$product_title) {
                $errors[] = "insert the name";
            }
            if (false === (bool)$description) {
                $errors[] = "insert the description";
            }
            if ($price === 0) {
                $errors[] = "insert the price";
            }

            $isFile = isset($_FILES['image']) && count($_FILES['image']) > 0;
            if (!$isFile) {
                header('location: ' . $_SERVER['PHP_SELF']);
                exit();
            }
            $dataFile = $_FILES['image']['tmp_name'][0];
            $filesize = filesize($dataFile);
            if (!$dataFile || !$filesize) {
                notificationErrorMessage("The image is empty");
                header("location: " . $_SERVER['PHP_SELF']);
                exit();
            }

            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $type = finfo_file($finfo, $dataFile);

            if ($filesize === 0) {
                $errors[] = "The data is empty";
            }
            if ($filesize !== 0) {
                $allowedfiles = [
                    'image/png' => 'png',
                    'image/jpg' => 'jpg',
                    'image/jpeg' => 'jpeg'
                ];
                if (!in_array($type, array_keys($allowedfiles))) {
                    notificationErrorMessage("This data ".$type." type is not allowed");
                    header("location: " . $_SERVER['PHP_SELF']);
                    exit();
                }

                $extension = $allowedfiles[$type];
                $path = __DIR__ . '/../asset/image/' . time() . '.' . $extension;
                if (!copy($dataFile, $path)) {
                    $errors[] = "could " . $dataFile . " not copy into" . $path;
                }
                unlink($dataFile);
            }

            $hasErrors = count($errors) > 0;
            if (false === $hasErrors) {
                $image = 'asset/image/' . time() . '.' . $extension;
                $created = createProduct($product_title, $description, $price, $image);
                if (false === $created) {
                    $errors[] = "Product could not be created";
                }
                if (true === $created) {
                    notificationMessage("The Product hase created successfully");
                    header("location: " . $_SERVER['PHP_SELF']);
                    exit();
                }
            }

        }
        //Edit product
        if (isset($_POST['edit_submit'])) {
            $product_ID = (int)filter_input(INPUT_POST, 'product_id', FILTER_SANITIZE_NUMBER_INT);
            $product_title = filter_input(INPUT_POST, "name", FILTER_SANITIZE_SPECIAL_CHARS);
            $description = filter_input(INPUT_POST, "description", FILTER_SANITIZE_SPECIAL_CHARS);
            $price = (int)filter_input(INPUT_POST, "price");
            if (false === (bool)$product_title) {
                $errors[] = "insert the name";
            }
            if (false === (bool)$description) {
                $errors[] = "insert the description";
            }
            if ($price === 0) {
                $errors[] = "insert the price";
            }

            $isFile = isset($_FILES['image']) && count($_FILES['image']) > 0;
            if (!$isFile) {
                header('location: ' . $_SERVER['PHP_SELF']);
                exit();
            }
            $dataFile = $_FILES['image']['tmp_name'][0];
            $filesize = filesize($dataFile);
            if (!$dataFile || !$filesize) {
                notificationErrorMessage("The image is empty");
                header("location: " . SITE_URL."edit_product.php");
                exit();
            }

            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $type = finfo_file($finfo, $dataFile);
            var_dump($type);
            if ($filesize === 0) {
                $errors[] = "The data is empty";
            }
            if ($filesize !== 0) {
                $allowedfiles = [
                    'image/png' => 'png',
                    'image/jpg' => 'jpg',
                    'image/jpeg' => 'jpeg'
                ];
                if (!in_array($type, array_keys($allowedfiles))) {
                    notificationErrorMessage("This data ".$type." type is not allowed");
                    header("location: ".SITE_URL."cardItems.php");
                    exit();
                }

                $extension = $allowedfiles[$type];
                $path = __DIR__ . '/../asset/image/' . time() . '.' . $extension;
                if (!copy($dataFile, $path)) {
                    $errors[] = "could " . $dataFile . " not copy into" . $path;
                }
                unlink($dataFile);
            }

            $hasErrors = count($errors) > 0;
            if (false === $hasErrors) {
                $image = 'asset/image/' . time() . '.' . $extension;
                $created = editProduct($product_ID, $product_title, $description, $price, $image);
                if (false === $created) {
                    $errors[] = "Product could not be created";
                }
                if (true === $created) {
                    notificationMessage("The Product hase edited successfully");
                    header("location: ".SITE_URL."cardItems.php");
                    exit();
                }
            }
        }
    }
    //Product Filter
    $low =  null;
    $high =  null;
    $products = [];
    $errors = [];
    if(isset($_POST['Filtersubmit'])) {
        $low = (int)filter_input(INPUT_POST, 'lowPrice', FILTER_SANITIZE_NUMBER_INT);
        $high = (int)filter_input(INPUT_POST, 'highPrice', FILTER_SANITIZE_NUMBER_INT);
        if (empty($low)){
            $errors[] = "please insert something";
        }
        if (empty($high)){
            $errors[] = "please insert something";
        }
        if (!empty($low)) {
            if ($low < 50000) {
                $errors[] = "Sorry, the product price begin in 50000";
            }
            if ($low > 140000) {
                $errors[] = "Sorry, we dont have the product price more than 140000";
            }
        }
        if (!empty($high)) {
            if ($high < 50000) {
                $errors[] = "Sorry, the product price begin in 50000";
            }
            if ($high > 140000) {
                $errors[] = "Sorry, we dont have the product price more than 140000";
            }
        }
        $hasErrors = count($errors) > 0;
        if (false === $hasErrors) {
            $filter_products = getAllProductPrice($low, $high);
        }
    }
    if(isset($_POST['filter'])){
        $beginTime =  filter_input(INPUT_POST,"low",FILTER_SANITIZE_SPECIAL_CHARS);
        $lastTime =  filter_input(INPUT_POST,"high",FILTER_SANITIZE_SPECIAL_CHARS);
        $products = filterProduct($beginTime,$lastTime);
    }
}
//Pagination
if (isset($_GET)) {
    $results_per_page = 4;
    $sql = "SELECT * FROM products";
    $result = getDb()->query($sql);

    $number_of_result = $result->rowCount();
    $number_of_page = ceil($number_of_result / $results_per_page);
    if (!isset($_GET['page'])) {
        $page = 1;
    } else {
        $page = $_GET['page'];
    }
    $this_page_first_result = ($page - 1) * $results_per_page;
    $sql = "SELECT * FROM products LIMIT " . $this_page_first_result . " , " . $results_per_page;
    $result = getDb()->query($sql);
    if (!$result) {
        return [];
    }
    $result->execute();
    $products = [];
    while ($row = $result->fetch()) {
        $products[] = $row;
    }
}

