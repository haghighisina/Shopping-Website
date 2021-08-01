<?php /** @noinspection ALL */
function addToCart(int $userId,string $product_name,int $product_id,int $product_price,int $quantity=1){
    $sql = "INSERT INTO cart SET   
            quantity= :quantity,
            user_id= :userId,
            product_name= :ProductName,
            product_id= :productId,
            product_price= :ProductPrice
            ON DUPLICATE KEY
            UPDATE quantity= quantity + :quantity, 
            product_price= product_price + :ProductPrice";
    $statement = getDb()->prepare($sql,[PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
    $data = [
        ':userId' => $userId,
        ':ProductName' =>$product_name,
        ':ProductPrice' => $product_price,
        ':productId' =>$product_id,
        ':quantity' => $quantity
    ];
    return $statement->execute($data);
}
function countProductsInCart(?int $userId):int{
    if(null === $userId){
        return 0;
    }
    $sql = "SELECT COUNT(id) FROM cart 
            WHERE user_id= :userId";
    $cartResult = getDb()->prepare($sql,[PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
    if (false === $cartResult){
        return 0;
    }
    $data = [':userId'=>$userId];
    $cartResult->execute($data);
    return $cartItems = $cartResult->fetchColumn();
}
function ifProductExistInCart(int $userId, int $product_id){
    $sql = "SELECT product_id FROM cart WHERE user_id= :UserID AND product_id= :ProductId";
    $statement = getDb()->prepare($sql,[PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
    if (false === $statement){return [];};
    $data = [':UserID'=>$userId,':ProductId' => $product_id];
    $statement->execute($data);
    return (int)$statement->fetchColumn();
}
function countCartItemsInCart(?int $userId):array{
    $sql = "SELECT product_name, product_price,product_id, quantity, price FROM cart
            JOIN products ON(cart.product_id = products.id)
            WHERE user_id= :userId";
    $statement = getDb()->prepare($sql,[PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
    if (false === $statement){return [];};
    $data = [':userId' => $userId];
    $statement->execute($data);
    $products = [];
    while ($row = $statement->fetch()){
        $products[] = $row;
    }
    return (array)$products;
}
function clearAllItemInCart(int $userid){
    $sql = "DELETE FROM cart WHERE user_id= :userId";
    $statement = getDb()->prepare($sql,[PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
    $statement->execute([':userId'=>$userid]);
}
function getCartAllItemsForUserId(?int $userId):array{
    if(null === $userId){
        return [];
    }
    $sql = "SELECT product_id,user_id,title,description,price,pic,product_price,quantity,created
            FROM cart 
            JOIN products ON(cart.product_id = products.id)
            WHERE user_id = :userId";
    $statement = getDb()->prepare($sql,[PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
    if (false === $statement){return [];}
    $data = [':userId' => $userId];
    $statement->execute($data);
    $found = [];
    while ($row = $statement->fetch()){
        $found[]=$row;
    }
    return $found;
}
function getCartSum(?int $userId):int{
    $sql = "SELECT SUM(price * quantity) FROM cart 
            JOIN products ON(cart.product_id = products.id) 
            WHERE user_id = :userId";
    $statement = getDb()->prepare($sql,[PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
    if (false === $statement){return 0;}
    $data = [':userId'=>$userId];
    $statement->execute($data);
    return (int)$statement->fetchColumn();
}
function deleteProductInCartForUserId(int $userId, int $productId):int{
    $sql ="DELETE FROM cart 
           WHERE user_id= :userId 
           AND product_id= :productId";
    $statement = getDb()->prepare($sql,[PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
    if ($statement === false){return 0;}
    $data = [
        ':userId'=>$userId,
        ':productId'=>$productId
    ];
    return (int)$statement->execute($data);
}
function updateCartItemsQuantity(int $quantity, int $product_price, int $product_id):bool{
    $sql = "UPDATE cart 
            SET quantity= :Quantity, product_price= :Product_price 
            WHERE product_id= :ID";
    $statement = getDb()->prepare($sql);
    $data = [
        ':Quantity'=>$quantity,
        ':Product_price'=>$product_price,
        ':ID'=>$product_id
    ];
    return $statement->execute($data);
}
function search(string $search):array{
    $search = "%$search%";
    $sql  = "SELECT * FROM products WHERE title LIKE ?";
    $stmt = getDb()->prepare($sql,[PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
    if (false === $stmt){
        return [];
    }
    $stmt->execute([$search]);
    $data = $stmt->fetchAll();
    return $data;
}