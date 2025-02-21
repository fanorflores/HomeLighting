<?php
require_once 'conection.php';

class ProductsLocal extends HLSynchlcubasSyncAPI
{
    private $table = 'homelightingproducts';

    public function __construct()
    {
        parent::__construct();
    }

    public function insertProduct($idGc, $idHL, $sku, $productsStockHL, $productHLData)
    {

        //INSERT INTO `hlcubassyncapi`.`homelightingproducts` (`idGcP`, `skuHL`, `sku`, `productsStockHL`, `productLastUpdateHL`, `productHLData`) VALUES ('341', '3443', 'dfgd454', '334', 'er454', '4545');

        $productLastUpdateHL = date('Y-m-d H:i:s');

        $sql = "INSERT INTO $this->table (idGcP, idHL, sku, productsStockHL, productLastUpdateHL, productHLData) 
                VALUES (?, ?, ?, ?, ?, ?)";

        $stmt = parent::getConnection()->prepare($sql);
        $stmt->bind_param('isssss', $idGc, $idHL, $sku, $productsStockHL, $productLastUpdateHL, $productHLData);

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

    public function getAllProducts()
    {
        $sql = "SELECT * FROM $this->table";
        $stmt = parent::getConnection()->prepare($sql);
        $stmt->execute();
        $result = $stmt->get_result();
        $products = [];

        while ($row = $result->fetch_assoc()) {
            $products[] = $row;
        }

        return json_encode($products);
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