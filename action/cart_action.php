<?php
if (isPost()){
    if (isset($_POST['submit'])){
        $product_name = filter_input(INPUT_POST,'product_name',FILTER_SANITIZE_SPECIAL_CHARS);
        $product_id = (int)filter_input(INPUT_POST,'product_id',FILTER_VALIDATE_INT);
        $product_price = (int)filter_input(INPUT_POST,'product_price',FILTER_SANITIZE_SPECIAL_CHARS);
        if (isLoggedIn()){
            if (ifProductExistInCart($userId, $product_id)){
                notificationErrorMessage('product has already exist in cart');
                header('location: ' . $_SERVER['PHP_SELF']);
                exit();
            }else{
                addToCart($userId, $product_name, $product_id, $product_price);
                notificationMessage('product has added in cart');
                header('location: ' . $_SERVER['PHP_SELF']);
                exit();
            }
        }elseif(!isLoggedIn()){
            notificationErrorMessage('You must log in first');
            header('location: ' . $_SERVER['PHP_SELF']);
            exit();
        }
    }
    if (isset($_POST['in_cart'])){
        notificationErrorMessage('product has been already added in cart');
        header('location: ' . $_SERVER['PHP_SELF']);
        exit();
    }
}


