<?php
if (isset($_GET['delete']) && $_GET['delete'] == 'delete') {
    deleteProductInCartForUserId($userId,$_GET['id']);
    notificationMessage('product has deleted from cart');
    header('location: '.$_SERVER['PHP_SELF']);
    exit();
}
if (isset($_GET['action']) && $_GET['action'] == 'Clear_Cart') {
    clearAllItemInCart($userId);
    notificationMessage('cart items has cleared');
    header('location: '.$_SERVER['PHP_SELF']);
    exit();
}
//change product quantity by ajax call
if (isset($_POST['Quantity'])){
    $product_quantity = (int)filter_input(INPUT_POST,'Quantity',FILTER_VALIDATE_INT);
    $product_price = (int)filter_input(INPUT_POST,'Price',FILTER_VALIDATE_INT);
    $product_id = (int)filter_input(INPUT_POST,'productID',FILTER_VALIDATE_INT);
    $total_price = (int)$product_quantity * $product_price;
    if ($product_quantity <= 0) {
        notificationErrorMessage('can not set the quantity lower than 0, must delete the product');
        header('location: '.$_SERVER['PHP_SELF']);
        exit();
    }
    if ($product_quantity > 10) {
        notificationErrorMessage('can not set the quantity higher than 10');
        header('location: '.$_SERVER['PHP_SELF']);
        exit();
    }
    $updateProductQuantity = updateCartItemsQuantity($product_quantity, $total_price, $product_id, $userId);
    if(true === $updateProductQuantity){
        notificationMessage('The quantity has changed successfully');
        header('location: ' . $_SERVER['PHP_SELF']);
        exit();
    }
}