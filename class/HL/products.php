<?php
require("conection.php");
require("class/LOCAL/productslocal.php");
class ProductsHL
{

    public function add()
    {
        $data = [
            'name' => 'Premium Quality',
            'type' => 'simple',
            'regular_price' => '21.99',
            'description' => 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.',
            'short_description' => 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.',
            'categories' => [
                [
                    'id' => 9
                ],
                [
                    'id' => 14
                ]
            ],
            'images' => [
                [
                    'id' => 42
                ],
                [
                    'src' => 'http://demo.woothemes.com/woocommerce/wp-content/uploads/sites/56/2013/06/T_2_back.jpg'
                ]
            ]
        ];
        // print_r($woocommerce->post('products', $data));
    }

    public function list($page)
    {
        $con = new Conection("v3");
        return $con->getWoocommerce()->get('products?per_page=100&page=' . $page);
        //woocommerce->get('products')
    }
    public function update()
    {
        $data = [
            'name' => 'Premium Quality',
            'type' => 'simple',
            'regular_price' => '21.99',
            'description' => 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget, tempor sit amet, ante. Donec eu libero sit amet quam egestas semper. Aenean ultricies mi vitae est. Mauris placerat eleifend leo.',
            'short_description' => 'Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.',
            'categories' => [
                [
                    'id' => 9
                ],
                [
                    'id' => 14
                ]
            ],
            'images' => [
                [
                    'id' => 42
                ],
                [
                    'src' => 'http://demo.woothemes.com/woocommerce/wp-content/uploads/sites/56/2013/06/T_2_back.jpg'
                ]
            ]
        ];  // print_r($woocommerce->post('products', $data));
    }
    public function getbysku($sku)
    {
        $con = new Conection("v3");
        return $con->getWoocommerce()->get("products?sku=" .  $sku);
    }



    public function customfield()
    {

        $con = new Conection("v3");

        $data = [
            'type' => 'select'
        ];

        print_r($con->getWoocommerce()->put('products/attributes/2', $data));

        return 0;
    }

    public function saveLocal($productdetails)
    {
        $prodLocal = new ProductsLocal();


        $idGcP = $productdetails->idGc;
        $idHL = $productdetails->idHl;
        $sku = $productdetails->sku;
        $productsStockHL = $productdetails->stock_quantity;
        $datahl = $productdetails->datahl;

        return $prodLocal->insertProduct($idGcP, $idHL, $sku, $productsStockHL, $datahl);
    }

    public function updateAttributeIdGc($productId, $newIdGc)
    {
        $con = new Conection("v3");

        // ID del producto a actualizar


        // Datos para actualizar el atributo personalizado
        $data = [
            'attributes' => [
                [
                    'id'      => 2,       // ID del atributo personalizado
                    'name'      => 'idGc',   // Nombre del atributo
                    'slug'      => 'pa_idgc', // WooCommerce requiere "pa_" para atributos globales
                    'position'  => 1,
                    'visible'   => false,   // NO será visible en la tienda
                    'variation' => false,   // No es un atributo de variación
                    'options'   => ['' . $newIdGc] // Valor del atributo
                ]
            ]
        ];

        // Actualizar el producto con el nuevo atributo
        try {
            $updated_product = $con->getWoocommerce()->put("products/$productId", $data);
            echo "<pre>";
            echo "Producto actualizado con idGc: " . print_r($updated_product, true);
            echo "</pre>";
        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
/*
$prod = new ProductsHL();
var_dump($prod->list());*/