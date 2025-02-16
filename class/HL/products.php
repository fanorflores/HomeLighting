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

    public function list()
    {
        $con = new Conection("v3");
        return $con->getWoocommerce()->get('products');
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

    public function customfield()
    {

        $con = new Conection("v3");

        $data = [
            'type' => 'select'
        ];

        print_r($con->getWoocommerce()->put('products/attributes/2', $data));

        return 0;
    }

    public function LoadLocal()
    {
        $prodLocal = new ProductsLocal();
        $prodHL = new ProductsHL();
        $products = json_encode($prodHL->list());
        $datajson = json_decode($products);
        foreach ($datajson as $productdetails) {

            $idGcP = $productdetails->id;
            $skuHL = $productdetails->sku;
            $productsStockHL = $productdetails->stock_quantity;
            echo ($prodLocal->insertProduct($idGcP, $skuHL, $productsStockHL, $products));
        }
        return 0;
    }
}
/*
$prod = new ProductsHL();
var_dump($prod->list());*/