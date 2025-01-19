<?php
require_once("class/HL/products.php");
echo ("<h1>Productos del Ecomerce</h1>");

$productos = new Products();
$pro = $productos->list();

foreach ($pro as $product) {
    print_r(json_decode(json_encode($product, true))->id);
    print_r(json_decode(json_encode($product, true))->sku);
    print_r(json_decode(json_encode($product, true))->id);
    print_r(json_decode(json_encode($product, true))->description);
    print_r(json_decode(json_encode($product, true))->slug);
}
