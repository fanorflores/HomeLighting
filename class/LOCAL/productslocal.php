<?php
require_once 'conection.php';

class ProductsLocal extends HLSynchlcubasSyncAPI
{
    private $table = 'homelightingproducts';

    public function __construct()
    {
        parent::__construct();
    }

    public function insertProduct($idGcP, $skuHL, $productsStockHL, $productHLData)
    {
        $productLastUpdateHL = date('Y-m-d H:i:s');
        $prodHLUpdate = null;

        $sql = "INSERT INTO $this->table (idGcP, skuHL, productsStockHL, productLastUpdateHL, productHLData, prodHLUpdate) 
                VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bind_param('isisss', $idGcP, $skuHL, $productsStockHL, $productLastUpdateHL, $productHLData, $prodHLUpdate);

        if ($stmt->execute()) {
            return parent::getLastId($this->table, 'idHomeLightingProducts');
        } else {
            return false;
        }
    }

    public function updateProduct($idGcP, $skuHL, $productsStockHL, $productHLData, $byAction)
    {
        $productLastUpdateHL = date('Y-m-d H:i:s');
        $prodHLUpdate = null;

        switch ($byAction) {
            case 'byidgc':
                $sql = "UPDATE $this->table SET idGcP = ?,  productLastUpdateHL = ?,productsStockHL = ?, productHLData = ?,  WHERE skuHL = ?";
                break;
        }


        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bind_param('isssis', $idGcP, $productLastUpdateHL, $productHLData, $prodHLUpdate, $productsStockHL, $skuHL);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
/*
$productLocal = new ProductsLocal();
$idGcP = 2;
$skuHL = 'SKU1234522';
$productsStockHL = 100;
$productHLData = json_encode(['name' => 'Product Name', 'description' => 'Product Description']);

$insertedId = $productLocal->insertProduct($idGcP, $skuHL, $productsStockHL, $productHLData);

if ($insertedId) {
    echo "Product inserted with ID: " . $insertedId;
} else {
    echo "Failed to insert product.";
}*/