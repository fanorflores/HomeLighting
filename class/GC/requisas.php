<?php
require_once("conection_gc.php");
require_once($_SERVER['SERVER_NAME'] . "/class/HL/orders.php");
class RequisasGC extends ApiClient
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getConsecutive()
    {
        parent::login();
        $curl = curl_init($this->baseUrl . '/api/material/requirement/consecutive');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization: Bearer ' . $this->authorization));
        curl_setopt($curl, CURLOPT_COOKIEFILE, $this->cookieFile);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_VERBOSE, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $result = curl_exec($curl);

        if ($result === false) {
            echo 'Error: ' . curl_error($curl);
        } else {

            return $result;
        }

        curl_close($curl);
    }


    public function createRequest($cart_key)
    {
        $prod = new OrdersHL();
        $carrito = json_decode($prod->getOorder($cart_key), true);



        $items_info = array_map(function ($item) {
            $datagc = new OrdersHL();
            $infoadditiona = $datagc->getcartIdGc($item['id']);

            return [
                'id' => $item['id'],
                'idGc' => $infoadditiona['idGc'],
                'descripcion' => $item['name'],
                'precio' => round(($infoadditiona['price'] * 1.15), 2),
                'cantidad' => $item['quantity']['value']
            ];
        }, $carrito['items']);



        $noRequisa = json_decode($this->getConsecutive(), true)['noRequisa'];

        $lstDetalle = array();
        foreach ($items_info as $item) {
            $lstDetalle[] = array(
                'id' => 0,
                'cantidadSolicitada' => $item['cantidad'],
                'idInventarioEstandar' => $item['idGc'],
                'precioUnitario' => $item['precio'],
                'deducible' => false
            );
        }

        $data = array(
            'id' => 0,
            'noRequisa' => $noRequisa,
            'idEmpleadoRegistro' => 118,
            'idEmpleadoResponsable' => 118,
            'idProyectoCliente' => 6547,
            'observacion' => 'HL Carrito: ' . $cart_key,
            'idAlmacen' => 1,
            'lstDetalle' => $lstDetalle
        );
        echo (json_encode($data));

        $curl = curl_init($this->baseUrl . '/api/material/requirement/');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json', $this->authorization));
        curl_setopt($curl, CURLOPT_COOKIEFILE, $this->cookieFile);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_VERBOSE, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));

        $result = curl_exec($curl);

        if ($result === false) {
            echo 'Error: ' . curl_error($curl);
        } else {

            return $result;
        }

        curl_close($curl);
    }

    public function getRequests($noRequisa)
    {
        parent::login();
        $curl = curl_init($this->baseUrl . '/api/material/requirement/' . $noRequisa);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json', 'Authorization: Bearer ' . $this->authorization));
        curl_setopt($curl, CURLOPT_COOKIEFILE, $this->cookieFile);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_VERBOSE, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $result = curl_exec($curl);

        if ($result === false) {
            echo 'Error: ' . curl_error($curl);
        } else {

            return $result;
        }

        curl_close($curl);
    }
}
