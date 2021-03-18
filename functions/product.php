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