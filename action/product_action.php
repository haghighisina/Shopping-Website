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
if (isset($_POST['submit'])){
    $product_quantity = (int)filter_input(INPUT_POST,'itemQuantity',FILTER_VALIDATE_INT);
    $product_price = (int)filter_input(INPUT_POST,'productPrice',FILTER_VALIDATE_INT);
    $product_id = (int)filter_input(INPUT_POST,'productId',FILTER_VALIDATE_INT);
    $total_price = (int)$product_quantity * $product_price;
    if ($product_quantity <= 0) {
        notificationErrorMessage('can not set the quantity lower than 0, must delete it');
        header('location: '.$_SERVER['PHP_SELF']);
        exit();
    }
    if ($product_quantity > 10) {
        notificationErrorMessage('can not add cart more than 10');
        header('location: '.$_SERVER['PHP_SELF']);
        exit();
    }
    updateCartItemsQuantity($product_quantity, $total_price, $product_id);
    notificationMessage('The quantity has changed successfully');
    header('location: '.$_SERVER['PHP_SELF']);
    exit();
}
if (isset($_POST['itemQuantity'])){
    notificationMessage('The quantity OK');
    header('location: '.$_SERVER['PHP_SELF']);
    exit();
}
