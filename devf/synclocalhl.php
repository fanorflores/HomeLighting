<?php
require_once("class/GC/products_gc.php");
require_once("class/HL/products.php");
require_once("class/LOCAL/productslocal.php");

$apiClient = new ProductsGC();
$hl = new ProductsHL();
$local = new ProductsLocal();

if ($apiClient->login()) {
    $gcdata = json_decode($apiClient->listProducts());
    $i = 0;
    foreach ($gcdata as $product) {


        if ($product->noParte != "") {

            $sku_encoded = str_replace(' ', '', $product->noParte);
            $hl_product = $hl->getbysku($sku_encoded);
            if (empty($hl_product)) {
                echo ++$i . " - SKU: " . $sku_encoded . " No existe en HL<br>";
            } else {
                //echo "<pre>";
                //var_dump($hl_product);
                // echo "</pre>";
                echo ++$i . " - Almacenado en: " . $local->insertProduct(
                    $product->id,
                    $hl_product[0]->id,
                    $sku_encoded,
                    $hl_product[0]->stock_quantity,
                    json_encode($hl_product[0])
                );
            }

            //var_dump($hl->getbysku($sku_encoded));
            //echo "SKU: " . $sku_encoded . "<br>";
            /*if ($hl->getbysku($sku_encoded) == null) {
                echo "SKU: " . $sku_encoded . "No existe en HL<br>";
            } else {
                echo "SKU: " . $sku_encoded . "Existe en HL<br>";
            }*/
        }
    }
} else {
    echo "Error al conectar a la API de GC";
}
