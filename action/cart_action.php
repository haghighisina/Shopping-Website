<?php
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
                notificationMessage('product has added in cart');
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
        if (isset($_POST['delete'])) {
            $product_id = (int)filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
            $product_name = filter_input(INPUT_POST, 'product_name', FILTER_SANITIZE_SPECIAL_CHARS);
            deleteProduct($product_id);
            notificationMessage("product " . $product_name . " has deleted from product section");
            header('location: ' . $_SERVER['PHP_SELF']);
            exit();
        }
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
            $allowedfiles = [
                'image/png' => 'png',
                'image/jpg' => 'jpg',
                'image/jpeg' => 'jpeg'
            ];
            if (!in_array($type, array_keys($allowedfiles))) {
                $errors[] = "This data is not allowed";
            }
            $extension = $allowedfiles[$type];

            $path = __DIR__ . '/../asset/image/' . time() . '.' . $extension;
            if (!copy($dataFile, $path)) {
                $errors[] = "could " . $dataFile . " not copy into" . $path;
            }
            unlink($dataFile);

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
                header("location: " . $_SERVER['PHP_SELF']);
                exit();
            }

            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $type = finfo_file($finfo, $dataFile);

            if ($filesize === 0) {
                $errors[] = "The data is empty";
            }
            $allowedfiles = [
                'image/png' => 'png',
                'image/jpg' => 'jpg',
                'image/jpeg' => 'jpeg'
            ];
            if (!in_array($type, array_keys($allowedfiles))) {
                $errors[] = "This data is not allowed";
            }
            $extension = $allowedfiles[$type];

            $path = __DIR__ . '/../asset/image/' . time() . '.' . $extension;
            if (!copy($dataFile, $path)) {
                $errors[] = "could " . $dataFile . " not copy into" . $path;
            }
            unlink($dataFile);

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
}



