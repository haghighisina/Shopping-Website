<?php /* @noinspection ALL */
function getCategories(?int $categoryId): array{
    $categories = [];
    $sql = "SELECT id,label,parentId,id=:categoryId as isPrimary
    FROM categories WHERE ";
    $tempSql = "parentId is null ";
    if ($categoryId) {
        $tempSql = "id= :categoryId OR parentId= :categoryId ";
    }

    $sql .= $tempSql;
    $sql .= "ORDER BY isPrimary DESC,`position`,label";

    $statement = getDB()->prepare($sql);
    if (false === $statement) {
        return $categories;
    }
    $statement->execute([':categoryId' => $categoryId]);
    if (0 === $statement->rowCount()) {
        return $categories;
    }
    while ($row = $statement->fetch()) {
        $categories[] = $row;
    }
    return $categories;
}
function getAllCategories():array{
    $category = [];
    $sql = "SELECT * FROM categories";
    $statement = getDb()->prepare($sql);
    if (false === $statement){
        return [];
    }
    $row = $statement->execute();
    while($row = $statement->fetch()){
        $category[] = $row;
    }
    return $category;
}

function findCategoryById(int $categoryId):?array{
    $sql = "SELECT id, label, parentId
            FROM categories
            WHERE id= :categoryId";
    $statement = getDb()->prepare($sql);
    if (false === $statement){
        return null;
    }
    $statement->execute([":categoryId"=>$categoryId]);
    if (0 === $statement->rowCount()){
        return null;
    }
    $categoryData = $statement->fetch();

    return $categoryData;
}