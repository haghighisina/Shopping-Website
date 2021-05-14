<?php /** @noinspection ALL */
function getAllProduct():array{
    $sql = "SELECT * FROM products";
    $result = getDb()->prepare($sql);
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
function getSearchProduct(int $product_id):array{
    $sql = "SELECT * FROM products WHERE id= :product_id";
    $result = getDb()->prepare($sql);
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
    $staement = getDb()->prepare($sql);
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
function deleteProduct(int $productId):int{
    $sql ="DELETE FROM products 
           WHERE id= :productId";
    $statement = getDb()->prepare($sql);
    if ($statement === false){return 0;}
    $data = [
        ':productId'=>$productId
    ];
    return (int)$statement->execute($data);
}






