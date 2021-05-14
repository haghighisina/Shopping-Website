<?php
if(false === isAdmin()){
    logData("Invalid Access","New_Product Page",['user_id'=>$userId]);
    header('location: index.php');
    exit();
}
require_once __DIR__ .'/product.php';
$product_title = "";
$description = "";
$price = 0;
$errors = [];
$hasErrors = false;
if (isAdmin()) {
    if (isServer("new_product.php")) {
        if (isPost()) {
            if (isset($_POST['submit'])) {
                $product_title = filter_input(INPUT_POST, "name", FILTER_SANITIZE_SPECIAL_CHARS);
                $description = filter_input(INPUT_POST, "description", FILTER_SANITIZE_SPECIAL_CHARS);
                $price = (int)filter_input(INPUT_POST, "price");
                if (false === (bool)$product_title) {
                    $errors[] = "insert the name";
                }
                if (false === (bool)$description){
                    $errors[]="insert the description";
                }
                if ($price === 0){
                    $errors[]="insert the price";
                }

                $isFile = isset($_FILES['image']) && count($_FILES['image']) > 0;
                if (!$isFile) {
                    header('location: '.$_SERVER['PHP_SELF']);
                    exit();
                }
                $dataFile = $_FILES['image']['tmp_name'][0];
                $filesize = filesize($dataFile);
                if (!$dataFile || !$filesize){
                    notificationMessage("The image is empty");
                    header("location: ".$_SERVER['PHP_SELF']);
                    exit();
                }

                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $type = finfo_file($finfo,$dataFile);

                if ($filesize === 0){
                    $errors[]="The data is empty";
                }
                $allowedfiles = [
                    'image/png' => 'png',
                    'image/jpg' => 'jpg',
                    'image/jpeg' => 'jpeg'
                ];
                if(!in_array($type,array_keys($allowedfiles))){
                    $errors[]="This data is not allowed";
                }
                $extension = $allowedfiles[$type];

                $path = __DIR__.'/../asset/image/'.time().'.'.$extension;
                if (!copy($dataFile,$path)){
                    $errors[]="could ".$dataFile." not copy into".$path;
                }
                unlink($dataFile);

                $hasErrors = count($errors)>0;
                if (false === $hasErrors){
                    $image = 'asset/image/'.time().'.'.$extension;
                    $created = createProduct($product_title, $description, $price, $image);
                    if (false === $created){
                        $errors[]="Product could not be created";
                    }
                    if (true === $created){
                        notificationMessage("The Product hase created successfully");
                        header("location: ".$_SERVER['PHP_SELF']);
                        exit();
                    }
                }
            }
        }
    }
}
?>