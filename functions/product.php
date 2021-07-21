<?php /** @noinspection ALL */
function getAllProduct():array{
    $sql = "SELECT * FROM products";
    $result = getDb()->prepare($sql,[PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
    if (!$result){
        return [];
    }
    $result->execute();
    $products = [];
    while($row = $result->fetch()){
        $products[] = $row;
    }
    return $products;
}
function getProductById($product_id):array{
    $sql = "SELECT * FROM products WHERE id= :ID";
    $result = getDb()->prepare($sql,[PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
    if (!$result){
        return [];
    }
    $result->execute([':ID'=>$product_id]);
    $products = [];
    while($row = $result->fetch()){
        $products[] = $row;
    }
    return $products;
}
function getSearchProduct(int $product_id):array{
    $sql = "SELECT * FROM products WHERE id= :product_id";
    $result = getDb()->prepare($sql,[PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
    if (!$result){return [];}
    $result->execute([':product_id' => $product_id]);
    $products = [];
    while($row = $result->fetch()){
        $products[] = $row;
    }
    return $products;
}
function createProduct(string $product_title,string $description,int $price, string $image):bool{
    $sql = "INSERT INTO products SET
            title= :ProductTitle,
            description= :Description,
            price= :Price,
            pic= :Pic";
    $staement = getDb()->prepare($sql,[PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
    if (false === $staement){
        return false;
    }
    $data = [
        ':ProductTitle' => $product_title,
        ':Description' => $description,
        ':Price' => $price,
        ':Pic' =>$image
    ];
    $staement->execute($data);
    $lastId = getDb()->lastInsertId();
    return $lastId > 0;
}
function editProduct(int $id, string $product_title,string $description,int $price, string $image):bool{
    $sql = "UPDATE products SET
            title= :ProductTitle,
            description= :Description,
            price= :Price,
            pic= :Pic
            WHERE id= :ID";
    $statement = getDb()->prepare($sql,[PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
    if (false === $statement){
        return false;
    }
    $data = [
        ':ProductTitle' => $product_title,
        ':Description' => $description,
        ':Price' => $price,
        ':Pic' =>$image,
        ':ID' => $id,
    ];
    $statement->execute($data);
    $rowCount = $statement->rowCount();
    return $rowCount > 0;
}
function deleteProduct(int $productId):int{
    $sql ="DELETE FROM products 
           WHERE id= :productId";
    $statement = getDb()->prepare($sql,[PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
    if ($statement === false){return 0;}
    $data = [
        ':productId'=>$productId
    ];
    return (int)$statement->execute($data);
}
function getAllProductPrice(int $low, int $high):array{
    $sql = "SELECT * FROM products WHERE price BETWEEN ".$low." AND ".$high." ORDER BY price ASC";
    $result = getDb()->prepare($sql,[PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
    if (!$result){return [];}
    $result->execute();
    $products = [];
    while($row = $result->fetch()){$products[] = $row;}
    return $products;
}




