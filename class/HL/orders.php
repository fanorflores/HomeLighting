<?php
require($_SERVER['SERVER_NAME'] . "/class/HL/conection.php");
require_once($_SERVER['SERVER_NAME'] . "/class/LOCAL/conection.php");
class OrdersHL
{
    public function getOorder($cart_key)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://homelighting.com.ni/wp-json/cocart/v2/cart?cart_key=" . $cart_key,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTPHEADER => array(
                'Accept: application/json',
                'User-Agent: CoCart API/v2'

            )
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;
        //woocommerce->get('products')
    }

    public function getLocalCarts()
    {
        $conn = new HLSynchlcubasSyncAPI();
        $query = "SELECT * FROM activations";
        $result = $conn->getConnection()->query($query);
        $carts = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $carts[] = $row;
            }
        }
        return $carts;
    }
    public function getcartIdGc($idHL)
    {
        $con = new Conection("v3");
        $product = $con->getWoocommerce()->get("products/" . $idHL);

        $result = [
            'idGc' => null,
            'price' => null
        ];

        if (isset($product->attributes)) {
            foreach ($product->attributes as $attribute) {
                if ($attribute->name === 'idGc' && isset($attribute->options[0])) {
                    $result['idGc'] = $attribute->options[0];
                }
            }
        }

        if (isset($product->price)) {
            $result['price'] = $product->price;
        }

        return $result; // Return the result array with idGc and price
    }
}
/*
$prod = new OrdersHL();
var_dump($prod->orders());*/