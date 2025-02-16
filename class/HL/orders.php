<?php
require("conection.php");
class OrdersHL
{
    public function orders()
    {
        $con = new Conection("v2");
        return $con->getWoocommerce()->get('cart');
        //woocommerce->get('products')
    }
}
/*
$prod = new OrdersHL();
var_dump($prod->orders());*/